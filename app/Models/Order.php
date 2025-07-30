<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'prescription_id',
        'order_date',
        'status'
    ];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }
}