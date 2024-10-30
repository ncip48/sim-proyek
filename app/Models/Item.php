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

    public function actual_stock()
    {
        $initial = Stock::where('item_id', $this->id)->where('type', 'initial')->first();
        $in = Stock::where('item_id', $this->id)->where('type', 'in')->first();
        $out = Stock::where('item_id', $this->id)->where('type', 'out')->first();

        $initialStock = $initial ? $initial->qty : 0;
        $inStock = $in ? $in->qty : 0;
        $outStock = $out ? $out->qty : 0;
        $totalStock = $initialStock + $inStock - $outStock;

        return $totalStock;
    }
}
