<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'description', 'completed_at', 'user_id',
    ];

    // Method to check if the task is completed
    public function isCompleted()
    {
        return !is_null($this->completed_at); // Returns true if completed_at is not null
    }
}
