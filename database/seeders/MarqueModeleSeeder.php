<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Marque;
use App\Models\Modele;
use Illuminate\Support\Facades\File;

class MarqueModeleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $path = public_path('JSON/car-list.json');

        if (!file_exists($path)) {
            echo "File car-list.json not found in public directory.";
            return;
        }

        $json = file_get_contents($path);
        $data = json_decode($json, true);

        foreach ($data as $entry) {
            $marque = Marque::create(['name' => $entry['brand']]);

            foreach ($entry['models'] as $modelName) {
                Modele::create([
                    'name' => $modelName,
                    'marque_id' => $marque->id
                ]);
            }
        }
    }
}
