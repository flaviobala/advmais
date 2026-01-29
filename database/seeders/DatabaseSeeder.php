<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Enums\VideoProvider; // Importante: Usando o Enum que criamos
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Criar Cursos
        $cursoPenal = Course::create([
            'title' => 'Direito Penal Avançado',
            'description' => 'Curso preparatório para segunda fase.',
        ]);

        $cursoMkt = Course::create([
            'title' => 'Marketing Jurídico na Prática',
            'description' => 'Como conseguir clientes sem ferir o código de ética.',
        ]);

        // 3. Criar Aulas (Lessons)
        Lesson::create([
            'course_id' => $cursoPenal->id,
            'title' => 'Aula 01 - Teoria do Crime',
            'video_provider' => VideoProvider::YOUTUBE, 
            'video_ref_id' => 'dQw4w9WgXcQ', // ID de teste do Youtube
            'order' => 1
        ]);

        Lesson::create([
            'course_id' => $cursoMkt->id,
            'title' => 'Aula 01 - Posicionamento no Instagram',
            'video_provider' => VideoProvider::VIMEO,
            'video_ref_id' => '76979871', // ID de teste do Vimeo
            'order' => 1
        ]);

        // 4. Criar Usuários de Teste
        // Usuário ADMIN (Vê tudo - futuramente)
        User::create([
            'name' => 'Admin AdvMais',
            'email' => 'admin@advmais.local',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);

        // Aluno OAB (Só deve ver Penal)
        User::create([
            'name' => 'Dr. João',
            'email' => 'joao@oab.teste',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'name' => 'Dra. Maria',
            'email' => 'maria@vip.teste',
            'password' => Hash::make('12345678'),
        ]);
        $this->call(CourseSeeder::class);
    }
}