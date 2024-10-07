<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'type',
        'message',
        'is_read',
        'is_checked',
        'notified_at',
    ];

    public function task() {
        return $this->belongsTo(Task::class);
    }
}
