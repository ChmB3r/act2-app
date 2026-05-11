<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Series;
use App\Models\Genre;

class ManhwaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $action = Genre::firstOrCreate(['name' => 'Action']);
        $fantasy = Genre::firstOrCreate(['name' => 'Fantasy']);
        $adventure = Genre::firstOrCreate(['name' => 'Adventure']);
        $isekai = Genre::firstOrCreate(['name' => 'Isekai']);

        $solo = Series::firstOrCreate(
            ['title' => 'Solo Leveling'],
            [
                'description' => 'In a world where hunters must battle deadly monsters to protect mankind from certain annihilation, a notoriously weak hunter named Sung Jinwoo finds himself in a seemingly endless struggle for survival.',
                'total_chapters' => 179,
            ]
        );
        $solo->genres()->syncWithoutDetaching([$action->id, $fantasy->id, $adventure->id]);

        $tbate = Series::firstOrCreate(
            ['title' => 'The Beginning After The End'],
            [
                'description' => 'King Grey has unrivaled strength, wealth, and prestige in a world governed by martial ability. However, solitude lingers closely behind those with great power.',
                'total_chapters' => 175,
            ]
        );
        $tbate->genres()->syncWithoutDetaching([$action->id, $fantasy->id, $isekai->id]);

        $omniscient = Series::firstOrCreate(
            ['title' => 'Omniscient Reader\'s Viewpoint'],
            [
                'description' => 'Dokja was an average office worker whose sole interest was reading his favorite web novel \'Three Ways to Survive the Apocalypse.\' But when the novel suddenly becomes reality, he is the only person who knows how the world will end.',
                'total_chapters' => 200,
            ]
        );
        $omniscient->genres()->syncWithoutDetaching([$action->id, $fantasy->id]);
    }
}
