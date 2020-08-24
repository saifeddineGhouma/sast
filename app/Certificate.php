<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\StudentCertificate;

use QRcode;
use Image;
use File;
use DB;

class Certificate extends Model
{


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name_ar',
        'name_en',
        'lecturer_ar',
        'lecturer_en',
        'description_ar',
        'description_en',
        'qrcodex',
        'qrcodey',
        'image',
        'image_width',
        'date'
    ];

    /**
     * The rules for validation.
     *
     * @var array
     */
    public function rules()
    {
        $id = $this->id;
        if (empty($id))
            $id = 0;
        return array(
            'name_ar' => 'required',
            'name_en' => 'required'
        );
    }

    /**
     * Get all items.
     *
     * @return collect
     */
    public static function getAll()
    {
        return self::select('*');
    }

    /**
     * Filter items.
     *
     * @return collect
     */
    public static function filter($request)
    {
        $query = self::select('certificates.*');
        return $query;
    }

    /**
     * Search items.
     *
     * @return collect
     */
    public static function search($request)
    {
        $query = self::filter($request);

        if (!empty($request->sort_order)) {
            $query = $query->orderBy($request->sort_order);
        }

        return $query;
    }

    public function certificate_contents()
    {
        return $this->hasMany("App\CertificateContent", "certificate_id");
    }

    public function student()
    {
        return $this->hasOne("App\Student", "student_id", "id");
    }

    public function coursetype_variations()
    {
        return $this->hasMany("App\CourseTypeVariation", "certificate_id");
    }

    public function x_output($x, $new_width)
    {
        return round(($x + 29 ) * $new_width / 800);
    }

    public function x_input($x, $image_width)
    {
        return round($x * 800 / $image_width);
    }

    public function y_output($y, $new_height, $height)
    {
        return round(($y + 29 ) * $new_height / $height);
    }

    public function export($student, $Arabic, &$serialnumber, &$new_image_name, $date = null)
    {

        include_once "assets/phpqrcode/qrlib.php";
        if (!isset($date)) {
            $date = $this->date;
        }
        $dir = 'uploads/kcfinder/upload/image/';
        $image_path = asset($dir . $this->image);
        $file_temp = $_SERVER['DOCUMENT_ROOT'] . "/" . $dir . $this->image;

        // code de test 
         //   $serialnumber = rand(1000000, 9999999) . rand(10000, 99999);

        if (file_exists($file_temp)) {
            $img = Image::make($image_path);
            $x = pathinfo($this->image);

            $serialnumber = rand(1000000, 9999999) . rand(10000, 99999);

         
            // $new_image_name = 'students certificates/' . $serialnumber . '.' . $x['extension'];
            $new_image_name = 'students certificates/' . $serialnumber . ' - ' . $student->user->full_name_en . '.' . $x['extension'];  //TODO badalt nom certificat
            foreach ($this->certificate_contents()->where("showoncertificate", 1)->get() as $certificate_content) {
                $value = "";
                if ($certificate_content->fieldcolumn == "serialnumber") {
                    $value = $serialnumber;
                } elseif ($certificate_content->fieldcolumn == "fullnameen") {
                    // ucwords
                    $value = strtoupper($student->user->full_name_en);
                } elseif ($certificate_content->fieldcolumn == "date") {
                    $value = date("Y-m-d");
                }
                $y_extra = 0;
                $x_extra = $certificate_content->fontsize * 3;
                if ($certificate_content->fontsize <= 20 && $certificate_content->fontsize >= 16) {
                    $y_extra = -10;
                    $x_extra = $certificate_content->fontsize * 3 ;
                    if ( $this->image_width != 1000) {
                        $x_extra -= 10;
                        $y_extra -= 5;
                    }
                }


                if ($certificate_content->fontsize < 16 && $certificate_content->fontsize >= 10) {
                   
                    $x_extra = $certificate_content->fontsize * 2  ;
                    $y_extra = - $certificate_content->fontsize + 5;
                    if ($certificate_content->fieldcolumn == "serialnumber" && $this->image_width == 1000) {
                        $x_extra += 10;
                    }
                    if ( $this->image_width != 1000) {
                        $x_extra -= 10;
                        $y_extra -= 5;
                    }
                }
                
                $xposition = $this->x_output($certificate_content->xposition + $x_extra, $this->image_width);
                $yposition = $this->y_output($certificate_content->yposition + $y_extra, $this->image_real_height, $this->image_height) + 5;
                
                $img->text(
                    $value,
                    $xposition,
                    $yposition,
                    function ($font) use ($certificate_content) {
                        $font->file('assets/admin/fonts/arial.ttf');
                        $font->size($certificate_content->fontsize);
                        $font->color($certificate_content->fontcolors);
                        $font->align('center');
                        $font->valign('middle');
                    }
                );
            }
            $img->save($dir . $new_image_name, 100);

            //writing barcode image

            if (!is_null($this->qrcodex) && !is_null($this->qrcodey)) {
                //$barcodeImg = QRcode::png($serialnumber);
                $barcodeImg = $dir . "barcodes/" . $serialnumber . "-code.png";
                $barcodeText = url(App('urlLang') . 'certificates/' . $serialnumber);
                $test = QRcode::png($barcodeText, $barcodeImg, QR_ECLEVEL_L, 4, 2);
                $QRcode = imagecreatefrompng($barcodeImg);

                $qrcodex = $this->x_output($this->qrcodex, $this->image_width) - 25;
                $qrcodey = $this->y_output($this->qrcodey , $this->image_real_height, $this->image_height) - 25 ;
               
                $sourceImage = imagecreatefromjpeg($dir . $new_image_name);
                imagecopy($sourceImage, $QRcode, $qrcodex, $qrcodey, 0, 0, imagesx($QRcode), imagesy($QRcode));
                imagejpeg($sourceImage, $dir . $new_image_name, 100);

                return;
            }
        }
        return;
    }
}
