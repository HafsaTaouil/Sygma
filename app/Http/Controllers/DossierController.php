<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dossier;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;



class DossierController extends Controller
{
    
    public function searchByDate(Request $request) {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        
        // Include the entire day for endDate
        $endDate = Carbon::parse($endDate)->endOfDay();
        
        $user = Auth::user();
        
        $dossiers = Dossier::where('user_id', $user->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with('modele.marque', 'dossierParties', 'user')
            ->get();
    
        return response()->json([
            'dossiers' => $dossiers,
        ]);
    }
    
    
    

}
