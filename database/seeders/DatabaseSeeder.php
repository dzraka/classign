<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ClassModel;
use App\Models\ClassEnrollment;
use App\Models\Assignment;
use App\Models\Material;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create sample users
        $teacher = User::create([
            'name' => 'teacher',
            'email' => 'teacher@example.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'display_name' => 'teacher',
        ]);

        $student1 = User::create([
            'name' => 'student1',
            'email' => 'student1@example.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'display_name' => 'student1',
        ]);

        $student2 = User::create([
            'name' => 'student2',
            'email' => 'student2@example.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'display_name' => 'student2',
        ]);

        // Create sample class
        $class = ClassModel::create([
            'name' => 'Pemrograman Web',
            'description' => 'Kelas pemrograman web untuk siswa kelas 4B',
            'class_code' => 'PW10',
            'teacher_id' => $teacher->id,
        ]);

        // Enroll students
        ClassEnrollment::create([
            'class_id' => $class->id,
            'student_id' => $student1->id,
        ]);

        ClassEnrollment::create([
            'class_id' => $class->id,
            'student_id' => $student2->id,
        ]);

        // Create sample material
        Material::create([
            'title' => 'HTML Dasar',
            'content' => 'Materi pengantar HTML untuk memahami konsep dasar struktur halaman web.',
            'class_id' => $class->id,
            'teacher_id' => $teacher->id,
        ]);

        // Create sample assignment
        Assignment::create([
            'title' => 'Latihan Soal HTML',
            'description' => '1. Pengumpulan bentuk link yang sudah diupload ke Github masing-masing.',
            'due_date' => now()->addDays(7),
            'max_score' => 100,
            'class_id' => $class->id,
            'teacher_id' => $teacher->id,
        ]);
    }
}
