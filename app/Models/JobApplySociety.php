<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplySociety extends Model
{
    use HasFactory;
    protected $table = 'job_apply_societies';

    protected $guarded = [];

    public $timestamps = false;

    public function vacancy() {
        return $this->belongsTo(JobVacancy::class, 'job_vacancy_id', 'id');
    }

    public function jobApplyPositions() {
        return $this->hasMany(JobApplyPosition::class, 'job_apply_societies_id', 'id');
    }
}
