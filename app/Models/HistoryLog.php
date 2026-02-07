<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoryLog extends Model
{
    protected $fillable = [
        'date',
        'action',
        'user',
        'details',
        'email',
    ];
}
