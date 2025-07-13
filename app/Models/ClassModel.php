<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'name',
        'description',
        'class_code',
        'teacher_id',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($class) {
            if (empty($class->class_code)) {
                $class->class_code = strtoupper(Str::random(6));
            }
        });
    }

    // Relationships
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'class_enrollments', 'class_id', 'student_id')
                    ->withTimestamps();
    }

    public function enrollments()
    {
        return $this->hasMany(ClassEnrollment::class, 'class_id');
    }

    public function materials()
    {
        return $this->hasMany(Material::class, 'class_id');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'class_id');
    }

    // Helper methods
    public function isEnrolledBy(User $user)
    {
        return \App\Models\ClassEnrollment::where('class_id', $this->id)
                                         ->where('student_id', $user->id)
                                         ->exists();
    }

    public function getStudentCount()
    {
        return $this->students()->count();
    }
}
