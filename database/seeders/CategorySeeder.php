<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Cursos Extras',
                'slug' => 'cursos-extras',
                'description' => 'Cursos complementares e materiais extras para sua formação',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Tecnologia',
                'slug' => 'tecnologia',
                'description' => 'Cursos de tecnologia e ferramentas digitais para advogados',
                'order' => 2,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }

        $this->command->info('Categorias criadas com sucesso!');
    }
}
