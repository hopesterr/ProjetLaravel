<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'board_id', 'user_id', 'title',
        'description', 'status', 'due_date',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'task_tag');
    }

    public function getStatusBadgeClass(): string
    {
        return match($this->status) {
            'todo'        => 'secondary',
            'in_progress' => 'warning',
            'done'        => 'success',
            default       => 'secondary',
        };
    }

    public function getStatusLabel(): string
    {
        return match($this->status) {
            'todo'        => 'À faire',
            'in_progress' => 'En cours',
            'done'        => 'Terminé',
            default       => $this->status,
        };
    }
}