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
