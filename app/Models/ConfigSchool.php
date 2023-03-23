<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigSchool extends Model
{
    use HasFactory;
    protected $fillable = ['school_id'];

    public function master_config(){
		return $this->belongsTo(Config::class,'code_config','code');
	}
}
