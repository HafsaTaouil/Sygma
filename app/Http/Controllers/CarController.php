<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marque;
use App\Models\Modele;
use App\Models\Dossier;


class CarController extends Controller
{
    public function getAllMarques(){
        $marques = Marque::all();
        return response()->json($marques);
    }

    //the parameter marqueId is going to come from teh request (js script) to the route in web.php then is going to pass as a parameter for the following fct

    /**
     * ? the first parameter of the where method is the actual name of the column that corresponds of the id of the marque of each modele in the Modele table in DB
     */

    public function getAllModelsByMarqueId($marqueId){
        $modeles = Modele::where('marque_id', $marqueId)->get();
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

        return response()->json([
            'dossiers' => $dossiers,
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
    
        return response()->json([
            'dossiers' => $dossiers,
        ]);
    }
    


    
    
}
