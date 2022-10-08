<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Validation extends Model
{
    use HasFactory;
    protected $table = 'validations';

    protected $guarded = [];

    public $timestamps = false;

    public function job_category(){
        return $this->belongsTo(JobCategory::class);
    }

    public function society(){
        return $this->belongsTo(Sociaty::class);
    }

    public function validator(){
        return $this->belongsTo(Validator::class);
    }
}
