<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

use DB;

class Order extends Model
{
    /**
     * Filter items.
     *
     * @return collect
     */
    public static function filter($request)
    {
        $query = self::select('orders.*')
            ->leftJoin('order_products', 'orders.id', '=', 'order_products.order_id');   // j'ai ajouté sa

        $parts = parse_url($request->extra);
        parse_str($parts['path'], $request1);

        if ($request1['category_id'] != 0) {
            if ($request1['category_id'] == 1) {
                $query = $query->leftJoin('coursetype_variations', 'order_products.coursetypevariation_id', '=', 'coursetype_variations.id')
                    ->leftJoin('course_types', 'coursetype_variations.coursetype_id', '=', 'course_types.id');
                $query = $query->where("course_types.type", '=', 'online');
            }
            if ($request1['category_id'] == 2) {
                $query = $query->leftJoin('coursetype_variations', 'order_products.coursetypevariation_id', '=', 'coursetype_variations.id')
                    ->leftJoin('course_types', 'coursetype_variations.coursetype_id', '=', 'course_types.id');
                $query = $query->where("course_types.type", '=', 'classroom');
            }
            if ($request1['category_id'] == 3) {
                $query = $query->where("orders.total", '=', '0.00');
            }
            if ($request1['category_id'] == 4) {
                $query = $query->where("order_products.pack_id", '!=', '0');
            }
        }

        /*if($request1['order_id']!=""){
            $query = $query->where("id",$request1['order_id']);
        }*/

        if ($request1['otype']) {
            if ($request1['otype'] == 'free') {
                $query = $query->where("orders.total", '=', '0.00');
            }
            if ($request1['otype'] == 'nofree') {
                $query = $query->where("orders.total", '>', '0.00');
            }
        }

        if ($request1['course_id'] != 0) {
            $query = $query->where("order_products.course_id", $request1['course_id']);   // j'ai modifié ici
        }

        if (isset($request1['user'])) {
            $user  = User::where('email', $request1['user'])->orWhere('username', $request1['user'])->first();
            if (isset($user)) {
                $query = $query->where("user_id", $user->id);
            }
        }

        if (!empty($request1['created_at'])) {
            $created_at =  date("y-m-d", strtotime($request1['created_at']));
            $query = $query->where(DB::raw("DATE(created_at)"), $created_at);
        }

        /*if (!empty($request1['paid'])) {
            $res = new Collection();
            foreach ($query as $item) {
                if ($request1['paid'] == 'yes') {
                    //dd($item->totalPaid());
                    if ($item->totalPaid() == '0.00' || $item->totalPaid() == '0' || $item->totalPaid() == '0.0')
                        continue;
                }
                if ($request1['paid'] == 'no') {
                    if ($item->totalPaid() > 0.00)
                        continue;
                }
                $res->push($item);
            }
            $query = $res;
        }*/
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
        return $query;
    }

    public function courseTypeVariation()
    {
        return $this->belongsTo("App\CourseTypeVariation", "coursetypevariation_id");
    }

    public function user()
    {
        return $this->belongsTo("App\User", "user_id");
    }

    public function courses()
    {
        return $this->belongsToMany("App\Course", "order_products", "order_id", "course_id");
    }

    public function coupon()
    {
        return $this->belongsTo("App\Coupon", "coupon_id");
    }

    public function orderproducts()
    {
        return $this->hasMany("App\OrderProduct", "order_id");
    }


    public function hasFiles()
    {
        $number = $this->orderproducts()->whereNotNull('order_products.files')->get()->count();
        return $number == 0 ? false : true;
    }

    public function order_onlinepayments()
    {
        return $this->hasMany("App\OrderOnlinepayment", "order_id");
    }

    public function totalPaid()
    {
        $totalPayment = $this->order_onlinepayments()
            ->select(DB::raw('sum(order_onlinepayments.total) as totalPaid'), "order_onlinepayments.payment_status")
            ->groupBy("order_onlinepayments.payment_status")
            ->having("order_onlinepayments.payment_status", "paid")
            ->first();
        if (!empty($totalPayment))
            return $totalPayment->totalPaid;
        else
            return 0.00;
    }
}
