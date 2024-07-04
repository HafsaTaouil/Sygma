<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModelesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = public_path('JSON/modeles.json');

        if (!file_exists($path)) {
            echo "File modeles.json not found in public directory.";
            return;
        }

        $json = file_get_contents($path);
        $data = json_decode($json);

        if (!$data) {
            echo "Invalid JSON format in modeles.json.";
            return;
        }

        foreach ($data as $modele) {
            $marque = $modele->mark;

            DB::table('modeles')->insert([
                'name' => $modele->name,
                'marque_id' => $marque->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        echo "Modeles table seeded successfully.";
    }
}
