<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class PartiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = public_path('JSON/parties.json');

        if (!file_exists($path)) {
            echo "File JSON/parties.json not found in public directory.";
            return;
        }

        $json = file_get_contents($path);
        $data = json_decode($json);

        if (!$data) {
            echo "Invalid JSON format in JSON/parties.json.";
            return;
        }

        foreach ($data as $obj) {
            DB::table('parties')->insert([
                'name' => $obj->name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        echo "Parties table seeded successfully.";
    }
}
