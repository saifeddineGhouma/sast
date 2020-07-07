<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country_id',
        'name',
        'mobile',
        'email',
        'address'
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
            'name' => 'required',
        );
    }

    public function country(){
		return $this->belongsTo('App\Country','country_id');
	}

    function getStatus($datafiled,$dataid){
        $span = '';
        $id = '';
        if ($datafiled==1) {
            $span = '<span class="label label-sm label-success"> active </span>';
            $id = 'on-'.$dataid;
        } else {
            $span = '<span class="label label-sm label-danger"> inactive </span>';
            $id = 'off-'.$dataid;
        }

        return '<a style="cursor: pointer;" class="activeIcon" data-id="'.$id.'"> '.$span.' </a>';
    }
	
}
