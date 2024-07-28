<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dossier; // Make sure to import the Dossier model

class DossierController extends Controller
{
    public function searchByDate(Request $request)
{
    $date = $request->input('query');

    $dossiers = Dossier::whereDate('created_at', $date)
        ->with('modele.marque', 'dossierParties', 'user')
        ->get();

    return response()->json([
        'dossiers' => $dossiers,
    ]);
}

}
