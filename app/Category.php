<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table="categories";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image'
    ];

    /**
     * The rules for validation.
     *
     * @var array
     */
    public function rules()
    {
        $id = $this->id;
        if(empty($id))
            $id=0;
        return array(
            'ar_name' => 'required',
            'ar_slug' => 'required|unique:categories_translations,slug,'.$id.',category_id',
            'en_slug' => 'required|unique:categories_translations,slug,'.$id.',category_id',
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
        $query = self::select('categories.*');

        // Keyword
//        if (!empty(trim($request->keyword))) {
//            foreach (explode(' ', trim($request->keyword)) as $keyword) {
//                $query = $query->where(function ($q) use ($keyword) {
//                    $q->orwhere('currencies.name', 'like', '%'.$keyword.'%')
//                        ->orWhere('currencies.code', 'like', '%'.$keyword.'%');
//                });
//            }
//        }
//
//        if(!empty($request->admin_id)) {
//            $query = $query->where('currencies.admin_id', '=', $request->admin_id);
//        }

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

	public function category_trans($lang){
		return $this->hasMany("App\CategoryTranslation","category_id")->where("lang",$lang)->first();
	}
//	public function products(){
//		return $this->belongsToMany("App\Product","products_categories","category_id","product_id");
//	}
	

}
   
