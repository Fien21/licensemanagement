<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class License extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'vendo_box_no',
        'license',
        'device_id',
        'description',
        'date',
        'technician',
        'email',
        'customer_name',
        'address',
        'contact',
        'sheet_name',
    ];

    public function getVendoBoxNoAttribute($value)
    {
        if ($this->date && $this->license && $this->device_id) {
            return Carbon::parse($this->date)->format('m-d-y') . '/' . substr($this->license, -5) . '-' . substr($this->device_id, -5);
        }
        return $value;
    }
}
