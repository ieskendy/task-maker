<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'description', 'status'];

    public function sub_tasks()
    {
        return $this->hasMany(SubTask::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public static function deleteTask($id)
    {
        $task = static::find($id);

        if ($task) {
            if ($task->delete()) {
                return true;
            }
        }

        return false;
    }
}
