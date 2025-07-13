<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'due_date',
        'max_score',
        'class_id',
        'teacher_id',
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    // Relationships
    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class, 'assignment_id');
    }

    // Helper methods
    public function isOverdue()
    {
        return Carbon::now(config('app.timezone'))->isAfter($this->due_date);
    }

    public function getSubmissionByStudent($studentId)
    {
        return $this->submissions()->where('student_id', $studentId)->first();
    }

    public function isSubmittedByStudent($studentId)
    {
        $submission = $this->getSubmissionByStudent($studentId);
        return $submission && $submission->isSubmitted();
    }

    public function getSubmissionCount()
    {
        return $this->submissions()->whereNotNull('submitted_at')->count();
    }

    public function getDaysLeft()
    {
        if ($this->isOverdue()) {
            return 0;
        }
        
        $now = Carbon::now(config('app.timezone'));
        $dueDate = Carbon::parse($this->due_date)->setTimezone(config('app.timezone'));
        
        // Hitung selisih dalam hari dengan pembulatan ke atas
        $days = $now->diffInDays($dueDate, false);
        
        // Jika kurang dari 1 hari, tampilkan dalam jam
        if ($days < 1) {
            $hours = $now->diffInHours($dueDate, false);
            if ($hours < 1) {
                return "< 1 jam";
            }
            return $hours . " jam";
        }
        
        return ceil($days);
    }

    public function getTimeLeft()
    {
        if ($this->isOverdue()) {
            return "Terlambat";
        }
        
        $now = Carbon::now(config('app.timezone'));
        $dueDate = Carbon::parse($this->due_date)->setTimezone(config('app.timezone'));
        
        // Hitung selisih dalam hari
        $days = $now->diffInDays($dueDate, false);
        
        // Jika kurang dari 1 hari, tampilkan dalam jam
        if ($days < 1) {
            $hours = $now->diffInHours($dueDate, false);
            if ($hours < 1) {
                $minutes = $now->diffInMinutes($dueDate, false);
                return $minutes . " menit lagi";
            }
            return $hours . " jam lagi";
        }
        
        // Jika 1 hari atau lebih
        $days = ceil($days);
        return $days . " hari lagi";
    }
}
