<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marque;
use App\Models\Modele;

class ModelLinkController extends Controller
{
    public function index() {
        $userId = auth()->id();
        $marques = Marque::whereHas('modeles.dossiers', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();
        return view('link-models', ['marques'=>$marques]);
    }


    // public function linkModels(Request $request) {
    //     $make1 = $request->input('make1');
    //     $model1 = $request->input('model1');
    //     $make2 = $request->input('make2');
    //     $model2 = $request->input('model2');

    //     $marque1 = Marque::where('name', $make1)->first();
    //     $modele1 = Modele::where('name', $model1)->where('marque_id', $marque1->id)->first();
        
    //     $marque2 = Marque::where('name', $make2)->first();
    //     $modele2 = Modele::where('name', $model2)->where('marque_id', $marque2->id)->first();

    //     if ($marque1 && $modele1 && $marque2 && $modele2) {
    //         $marque1Id = $marque1->id;
    //         $modele1Id = $modele1->id;
    //         $marque2Id = $marque2->id;
    //         $modele2Id = $modele2->id;

    //         return response()->json([
    //             'status' => 'success',
    //             'marque1_id' => $marque1Id,
    //             'modele1_id' => $modele1Id,
    //             'marque2_id' => $marque2Id,
    //             'modele2_id' => $modele2Id,
    //         ]);
    //     } else {
    //         return response()->json(['status' => 'error', 'message' => 'Make or model not found'], 404);
    //     }
    // }
    public function linkModels(Request $request)
    {
        // Retrieve the inputs from the request
        $make1 = $request->input('make1');
        $model1 = $request->input('model1');
        $make2 = $request->input('make2');
        $model2 = $request->input('model2');

        // Fetch the first marque and model
        $marque1 = Marque::where('name', $make1)->first();
        $modele1 = Modele::where('name', $model1)
                          ->where('marque_id', $marque1->id)
                          ->first();

        // Fetch the second marque and model
        $marque2 = Marque::where('name', $make2)->first();
        $modele2 = Modele::where('name', $model2)
                          ->where('marque_id', $marque2->id)
                          ->first();

        if ($marque1 && $modele1 && $marque2 && $modele2) {
            // Get pieces from the second model that do not exist in the first model
            $targetPieces = $modele2->piecesParties()->get();

            foreach ($targetPieces as $targetPiece) {
                $exists = $modele1->piecesParties()
                    ->where('piece_id', $targetPiece->pivot->piece_id)
                    ->where('partie_id', $targetPiece->pivot->partie_id)
                    ->exists();

                if (!$exists) {
                    $modele1->piecesParties()->attach($targetPiece->id, [
                        'partie_id' => $targetPiece->pivot->partie_id,
                        'min_year' => $targetPiece->pivot->min_year,
                        'max_year' => $targetPiece->pivot->max_year
                    ]);
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Missing pieces linked successfully!',
                'marque1_id' => $marque1->id,
                'modele1_id' => $modele1->id,
                'marque2_id' => $marque2->id,
                'modele2_id' => $modele2->id,
            ]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Make or model not found'], 404);
        }
    }

}
