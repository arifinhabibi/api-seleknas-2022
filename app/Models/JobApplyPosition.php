<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplyPosition extends Model
{
    use HasFactory;
    protected $table = 'job_apply_positions';
    protected $guarded = [];
    public $timestamps = false;


    public function society(){
        return $this->belongsTo(Society::class);
    }

    public function job_vacancy(){
        return $this->belongsTo(JobVacancy::class);
    }

    public function available_positions(){
        return $this->belongsTo(AvailablePosition::class, 'position_id', 'id');
    }

    public function job_apply_society(){
        return $this->belongsTo(JobApplySociety::class);
    }
}
