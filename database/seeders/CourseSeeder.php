<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Lesson;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Cria um Curso de Exemplo
        $curso = Course::create([
            'title' => 'Curso de Direito Penal - Parte Geral',
            'description' => 'Aprenda os fundamentos do Direito Penal com foco na OAB.',
            'cover_image' => 'https://via.placeholder.com/640x480.png/004466?text=Direito+Penal',
        ]);

        // 2. Cria as Aulas deste curso
        $aulas = [
            ['title' => 'Introdução aos Princípios Penais', 'video_ref_id' => '123456789'],
            ['title' => 'Teoria do Crime', 'video_ref_id' => '987654321'],
            ['title' => 'Aplicação da Pena', 'video_ref_id' => '456123789'],
        ];

        foreach ($aulas as $index => $aula) {
            Lesson::create([
                'course_id' => $curso->id,
                'title' => $aula['title'],
                'order' => $index + 1,
                'video_provider' => 'vimeo',
                'video_ref_id' => $aula['video_ref_id'],
                'duration_seconds' => 3600, // 1 hora fictícia
            ]);
        }
    }
}