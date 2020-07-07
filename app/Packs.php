<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class Packs extends Model
{
   protected $table = "packs";   
   public $incrementing = false;
   
   protected $fillable = [
        'cours_id1',
        'cours_id2',
        'prix'
    ];

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
   
