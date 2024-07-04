<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class MarquesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = public_path('JSON/marques.json');

        if (!file_exists($path)) {
            echo "File marques.json not found in public directory.";
            return;
        }

        $json = file_get_contents($path);
        $data = json_decode($json, true);

        if (!$data) {
            echo "Invalid JSON format in marques.json.";
            return;
        }

        foreach ($data as $entry) {
            // Insérer la marque
            $marqueId = DB::table('marques')->insertGetId([
                'name' => $entry['brand'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insérer les modèles associés à cette marque
            foreach ($entry['models'] as $modelName) {
                DB::table('modeles')->insert([
                    'name' => $modelName,
                    'marque_id' => $marqueId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        echo "Marques and modeles tables seeded successfully.";
    }
}
