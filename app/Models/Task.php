<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    // Permette l'assegnazione in massa di questi campi
    protected $fillable = [
        'title',
        'description',
        'max_assignments',
    ];

    // Relazione: una task ha molti guest
    public function guests()
    {
        return $this->hasMany(Guest::class);
    }
}
