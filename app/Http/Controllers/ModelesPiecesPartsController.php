<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Modele;
use App\Models\Piece;
use App\Models\Partie;
use Illuminate\Support\Facades\DB;

class ModelesPiecesPartsController extends Controller
{
    public function store(Request $request)
{
    // Validate the incoming request data
    $validatedData = $request->validate([
        'piece_id' => 'required|exists:pieces,id',
        'min_year' => 'required|integer',
        'max_year' => 'required|integer',
    ]);

    $refererUrl = $request->server->get('HTTP_REFERER');

    $queryParams = parse_url($refererUrl, PHP_URL_QUERY);
    parse_str($queryParams, $queryParameters);

    $modele_id = $queryParameters['modele_id'] ?? null;
    $part_id = $queryParameters['part_id'] ?? null;

    $modele = Modele::find($modele_id);

    if (!$modele) {
        return redirect()->back()->with('error', 'Modele not found.');
    }

    // Find the piece based on piece_id
    $piece = Piece::find($validatedData['piece_id']);

    if (!$piece) {
        return redirect()->back()->with('error', 'Piece not found.');
    }

    $partie = Partie::find($part_id);

    $modele->piecesParties()->attach($piece, [
        'partie_id' => $partie ? $partie->id : null,
        'min_year' => $validatedData['min_year'],
        'max_year' => $validatedData['max_year'],
    ]);

    return redirect()->route('marques.index')->with('success', 'Data inserted successfully.');
}

public function hasPieces($partId, $modeleId)
{
    $pieces = DB::table('modeles_pieces_parts')
                ->join('pieces', 'modeles_pieces_parts.piece_id', '=', 'pieces.id')
                ->where('modeles_pieces_parts.partie_id', $partId)
                ->where('modeles_pieces_parts.modele_id', $modeleId)
                ->select('pieces.*')
                ->get();

    $hasPieces = !$pieces->isEmpty();

    return response()->json([
        'hasPieces' => $hasPieces,
        'pieces' => $pieces
    ]);
}



}
