<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['project_id', 'title', 'description', 'status'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function statusHistory()
    {
        return $this->hasMany(StatusHistory::class);
    }
}
