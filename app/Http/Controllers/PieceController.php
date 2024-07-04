<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Piece;
use App\Models\Marque;
use App\Models\Partie;
use App\Models\Modele;
use DB;





class PieceController extends Controller
{
    public function index()
    {

        $pieces = Piece::with(['parties', 'parties.modeles.marque'])->get();

        return view("pieces", compact('pieces'));

    }

    public function showAddToModelForm(Request $request)
    {
        $pieceId = $request->query('piece');
        $marques = Marque::with('modeles')->get();
        $parties = Partie::all();
        return view('piece_form', compact('marques', 'parties', 'pieceId'));
    }


    public function assignPieceToModelePart(Request $request)
    {
        $modeleId = $request->query('modele_id');
        $partId = $request->query('part_id');

        $pieces = Piece::all();

        return view("add_pieces", compact('modeleId', 'partId', 'pieces'));
    }

    public function store(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|max:2048',
            'prix_reparation' => 'required|string|max:255',
            'prix_remplacement' => 'required|string|max:255',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $this->handleImage($image);
            $validatedData['image'] = $imagePath;
        }

        // Create a new piece record
        Piece::create($validatedData);

        // Redirect back or to a success page
        return redirect()->back()->with('success', 'Piece added successfully!');
    }


    public function update(Request $request, Piece $piece)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|max:2048',
            'prix_reparation' => 'required|string|max:255',
            'prix_remplacement' => 'required|string|max:255',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $this->handleImage($image);
            $validatedData['image'] = $imagePath;
        }

        
        // Update piece record
        $piece->update($validatedData);

        return redirect()->back()->with('success', 'Piece updated successfully!');
    }


    public function destroy(Piece $piece)
    {
        // Check if the piece is associated with any entries in the modeles_pieces_parts table
        $isInModelesPiecesParts = DB::table('modeles_pieces_parts')
            ->where('piece_id', $piece->id)
            ->exists();
    
        if ($isInModelesPiecesParts) {
            return redirect()->back()->with('error', 'Impossible de supprimer la pièce, elle est associée à des modeles.');
        }
    
        // Delete the piece
        $piece->delete();
    
        return redirect()->back()->with('success', 'Pièce supprimée avec succès !');
    }
    

    protected function handleImage($image)
    {
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('assets/images/Pieces'), $name_gen);
        $imagePath = 'assets/images/Pieces/' . $name_gen;
        return $imagePath;
    }


    public function storeModelPiece(Request $request)
    {
        $request->validate([
            'piece_id' => 'required|exists:pieces,id',
            'modele_id' => 'required|exists:modeles,id',
            'partie_id' => 'required|exists:parties,id',
            'min_year' => 'required|numeric',
            'max_year' => 'required|numeric',
        ]);

        $modele = Modele::findOrFail($request->modele_id);

        // Attach piece to modele with partie, min_year, max_year
        $modele->piecesParties()->attach($request->piece_id, [
            'partie_id' => $request->partie_id,
            'min_year' => $request->min_year,
            'max_year' => $request->max_year,
        ]);

        return redirect()->route('pieces.index')->with('success', 'Piece added to model successfully');
    }


}
