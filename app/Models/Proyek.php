<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Proyek extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'projects';

    protected $fillable = [
        'name',
        'location',
        'start_date',
        'end_date',
        'budget',
        'is_done'
    ];

    public function stocks()
    {
        return $this->hasMany(Stock::class, 'id', 'project_id');
    }
}
