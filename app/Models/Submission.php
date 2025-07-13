<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'file_path',
        'original_filename',
        'score',
        'feedback',
        'submitted_at',
        'assignment_id',
        'student_id',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    // Relationships
    public function assignment()
    {
        return $this->belongsTo(Assignment::class, 'assignment_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // Helper methods
    public function isSubmitted()
    {
        return !is_null($this->submitted_at);
    }

    public function isGraded()
    {
        return !is_null($this->score);
    }

    public function getStatusAttribute()
    {
        if (!$this->isSubmitted()) {
            return 'Belum Dikumpulkan';
        }
        
        if (!$this->isGraded()) {
            return 'Menunggu Penilaian';
        }
        
        return 'Dinilai';
    }
}
