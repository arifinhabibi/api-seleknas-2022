<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailablePosition extends Model
{
    use HasFactory;
    protected $table = 'available_positions';

    protected $guarded = [];

    public $timestamps = false;

    protected $hidden = ['id', 'job_vacancy_id'];

}
