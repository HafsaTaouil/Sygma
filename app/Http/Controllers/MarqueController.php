<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Marque;

use Illuminate\Http\Request;

class MarqueController extends Controller
{
    public function index(Request $request)
    {
        $marques = Marque::orderBy('name', 'asc')->with('modeles')->get();
        return view('marques', compact('marques'));
    }


    public function showModeles($marque_id)
    {
        $marque = Marque::with('modeles')->findOrFail($marque_id);
        return response()->json($marque->modeles);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:marques,name',
        ]);

        $marque = new Marque();
        $marque->name = $request->name;
        $marque->save();

        // Flash the session variable with a delay
        return redirect()->back()->with('marque_created', true)->withDelay(500);
    }


}
