<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CertificateContent extends Model
{
    protected $table="certificate_content";
    public $timestamps = false;

    public function certificate(){
        return $this->belongsTo("Certificate","certificate_id");
    }
}
   
