<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeLog extends Model
{
    protected $fillable = ['user_id','work_date','project','task_description','time_spent'];
}
