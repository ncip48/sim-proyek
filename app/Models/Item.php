<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Item extends Model
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $fillable = ['name', 'unit', 'price'];

    public function transactions()
    {
        return $this->hasMany(Stock::class);
    }
}
