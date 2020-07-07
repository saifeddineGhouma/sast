<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class Book extends Model
{


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'promo_points',
        'price',
        'points',
        'image',
        'pdf_book',
        'pdf_book_summary',
        'buy_link',
        'indicative_price'
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
            'ar_name' => 'required',
            'ar_slug' => 'required|unique:book_translations,slug,' . $id . ',book_id',
            'en_slug' => 'required|unique:book_translations,slug,' . $id . ',book_id',
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
        $query = self::select('books.*');
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

    public function book_trans($lang)
    {
        return $this->hasMany("App\BookTranslation", "book_id")->where("lang", $lang)->first();
    }

    public function orders()
    {
        return $this->belongsToMany("App\Order", "order_products", "course_id", "order_id");
    }

    public function order_products()
    {
        return $this->hasMany("App\OrderProduct");
    }

    public function book_downloads()
    {
        return $this->hasMany("App\BookDownload");
    }
    // if($countDownloads/$countOrders<3)

    public function isTotalPaid()
    {
        $isPaid = false;
        if (Auth::check()) {
            $countOrders = $this->order_products()
                ->whereHas('orderproducts_students', function ($query) {
                    $query->where("student_id", Auth::user()->id);
                })->join("orders", "order_products.order_id", "=", "orders.id")
                ->join("order_onlinepayments", "order_onlinepayments.order_id", "=", "orders.id")
                ->where("order_onlinepayments.payment_status", "paid")
                /*->select(DB::raw("sum(order_onlinepayments.total) as sumPayments"),"orders.id","orders.total")
                ->groupBy("orders.id","orders.total")
                ->havingRaw("sum(order_onlinepayments.total)>=orders.total")*/
                ->count();

            if ($countOrders > 0) {
                $countDownloads = $this->book_downloads()->where("user_id", Auth::user()->id)
                    ->count();
                $isPaid = true;
            }
        }
        return $isPaid;
    }
}
