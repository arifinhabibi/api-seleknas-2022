<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobVacancy extends Model
{
    use HasFactory;
    protected $table = 'job_vacancies';
    protected $guarded = [];

    public $timestamps = false;

    protected $hidden = ['job_category_id'];

    public function job_category(){
        return $this->belongsTo(JobCategory::class);
    }

    public function available_position(){
        return $this->hasMany(AvailablePosition::class);
    }
}
