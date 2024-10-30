<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class Stock extends Model
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $fillable = ['item_id', 'project_id', 'qty', 'type', 'date'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
