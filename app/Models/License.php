<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class License extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'vendo_box_no',
        'vendo_machine',
        'license',
        'device_id',
        'description',
        'date',
        'technician',
        'email',
        'customer_name',
        'address',
        'contact',
        'status',
    ];
}
