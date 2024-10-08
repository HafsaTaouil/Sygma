<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marque;
use App\Models\Modele;
use App\Models\Dossier;
use Carbon\Carbon;



class CarController extends Controller
{
    public function getAllMarques() {
        $userId = auth()->id();
        
        $marques = Marque::whereHas('modeles.dossiers', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();
    
        return response()->json($marques);
    }
    

    //the parameter marqueId is going to come from teh request (js script) to the route in web.php then is going to pass as a parameter for the following fct

    /**
     * ? the first parameter of the where method is the actual name of the column that corresponds of the id of the marque of each modele in the Modele table in DB
     */

     public function getAllModelsByMarqueId($marqueId) {
        $userId = auth()->id();
    
        $modeles = Modele::where('marque_id', $marqueId)
            ->whereHas('dossiers', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->get();
    
        return response()->json($modeles);
    }
    


    public function searchByMarque($marqueName){
        $userId = auth()->id();

        $dossiers = Dossier::where('user_id', $userId)
            ->whereHas('modele', function ($q) use ($marqueName) {
                $q->whereHas('marque', function ($q2) use ($marqueName) {
                    $q2->where('name', 'LIKE', "%$marqueName%");
                });
            })
            ->with('modele.marque', 'dossierParties', 'user')
            ->get();


            $colors = [];
            $severityMap = [
                1 => '107 114 128',
                2 => '179 213 232',
                3 => '4 153 253',
                4 => '252 2 4',
                5 => '0 0 0',
            ];
    
            foreach ($dossiers as $dossier) {
                foreach ($dossier->dossierParties as $part) {
                    $partId = $part->partie_id;
                    $damage = $part->damage;
                    $colors[$dossier->id][$partId] = $severityMap[$damage] ?? '255 255 255';
                }
            }
    
            $dossiers->each(function ($dossier) {
                $dossier->first_registration = Carbon::parse($dossier->first_registration)->format('d-m-Y');
                $dossier->validity_end = Carbon::parse($dossier->validity_end)->format('d-m-Y');
                $dossier->MC_maroc = Carbon::parse($dossier->MC_maroc)->format('d-m-Y');
            });


        return response()->json([
            'dossiers' => $dossiers,
            'colors' => $colors
        ]);
    }
    public function searchByModele($modeleName) {
        $userId = auth()->id();
    
        $dossiers = Dossier::where('user_id', $userId)
            ->whereHas('modele', function ($q) use ($modeleName) {
                $q->where('name', 'LIKE', "%$modeleName%");
            })
            ->with('modele.marque', 'dossierParties', 'user')
            ->get();

            

            $colors = [];
            $severityMap = [
                1 => '107 114 128',
                2 => '179 213 232',
                3 => '4 153 253',
                4 => '252 2 4',
                5 => '0 0 0',
            ];
    
            foreach ($dossiers as $dossier) {
                foreach ($dossier->dossierParties as $part) {
                    $partId = $part->partie_id;
                    $damage = $part->damage;
                    $colors[$dossier->id][$partId] = $severityMap[$damage] ?? '255 255 255';
                }
            }
    
            $dossiers->each(function ($dossier) {
                $dossier->first_registration = Carbon::parse($dossier->first_registration)->format('d-m-Y');
                $dossier->validity_end = Carbon::parse($dossier->validity_end)->format('d-m-Y');
                $dossier->MC_maroc = Carbon::parse($dossier->MC_maroc)->format('d-m-Y');
            });


    
        return response()->json([
            'dossiers' => $dossiers,
            'colors' => $colors
        ]);



    }
    


    
    
}
