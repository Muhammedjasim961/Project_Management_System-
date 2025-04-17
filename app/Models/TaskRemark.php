<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskRemark extends Model
{
    protected $fillable = ['task_id', 'remark', 'remark_date'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
