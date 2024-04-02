<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'Name',
        'Description',
        'Date',
        'Status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function item()
    {
        return $this->hasOne(Item::class, 'inventory_id');
    }
}
