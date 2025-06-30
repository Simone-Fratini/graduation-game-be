<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guest extends Model
{
    use HasFactory;

    // I campi che possono essere riempiti in massa
    protected $fillable = [
        'full_name',
        'email',
        'task_id',
        'changed_task',
    ];

    // Relazione: un guest appartiene a una task
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
