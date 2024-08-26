<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DossierPartie;
use App\Models\Dossier;
use App\Models\Etapes;
use Illuminate\Support\Str;
use App\Models\Modele;
use App\Models\Marque;
use App\Models\Orders;
use App\Models\Partie;
use App\Models\Piece;

use App\Models\Questions;
use DateTime;
use Illuminate\Support\Carbon;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\DB as FacadesDB;

class DashboardController extends Controller
{

    public function dossiers()
    {
        $userId = auth()->user()->id;
        $dossiers = Dossier::with('modele', 'modele.marque', 'dossierParties', 'user')
            ->where('user_id', $userId)
            ->orderBy('created_at','desc')
            ->get();

        // Prepare colors
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

        return view('dossiers', ['dossiers' => $dossiers, 'colors' => $colors]);
    }




    public function addDossierIndex()
    {
        return view('add_dossier');
    }


    public function store(Request $request)
    {
        // Check if the model already exists by name (case-insensitive)
        $modelName = ucwords(strtolower($request['data']['Machine']['modele']));
        $existingModel = Modele::where('name', $modelName)->first();
    
        if (!$existingModel) {
            // Create and save the Modele if it doesn't exist
            $model = new Modele();
            $model->name = $modelName;
    
            // Check if the marque already exists by name (case-insensitive)
            $marqueName = ucwords(strtolower($request['data']['Machine']['marque']));
            $existingMarque = Marque::where('name', $marqueName)->first();
    
            if (!$existingMarque) {
                // Create and save the Marque if it doesn't exist
                $mark = new Marque();
                $mark->name = $marqueName;
                $mark->save();
            } else {
                // Use the existing Marque
                $mark = $existingMarque;
            }
    
            $model->marque_id = $mark->id;
            $model->save();
        } else {
            // Use the existing Modele
            $model = $existingModel;
        }
    
        // Create and save the Dossier
        $dossier = new Dossier();
        $dossier->modele()->associate($model);
        $dossier->registration_number = $request['data']['Machine']['num_imma'];
        $dossier->previous_registration = $request['data']['Machine']['num_imma_ante'];
        $dossier->usage = $request['data']['Machine']['v_usage'];
        $dossier->address = $request['data']['Machine']['adresse'];
        $dossier->type = $request['data']['Machine']['type_carburant'];
        $dossier->chassis_nbr = $request['data']['Machine']['n_chassis'];
        $dossier->cylinder_nbr = $request['data']['Machine']['n_cylindres'];
        $dossier->fiscal_power = $request['data']['Machine']['puissance'];
    
        // Handle date fields with default values if parsing fails
        $dateString = $request['data']['Machine']['date_mc'];
        $date = DateTime::createFromFormat('d-M-Y', $dateString);
        $dossier->first_registration = $date ? $date->format('Y-m-d') : '1970-01-01';
    
        $dateString1 = $request['data']['Machine']['date_mc_maroc'];
        $date1 = DateTime::createFromFormat('d-M-Y', $dateString1);
        $dossier->MC_maroc = $date1 ? $date1->format('Y-m-d') : '1970-01-01';
    
        $dateString2 = $request['data']['Machine']['fin_valide'];
        $date2 = DateTime::createFromFormat('d-M-Y', $dateString2);
        $dossier->validity_end = $date2 ? $date2->format('Y-m-d') : '1970-01-01';
    
        $dossier->genre = $request['data']['Machine']['genre'];
        $dossier->owner = $request['data']['Machine']['name'];
        $dossier->fuel_type = $request['data']['Machine']['type_carburant'];
        $dossier->user_id = auth()->user()->id;
    
        $dossier->save();
    
        // Handle file uploads for the Dossier
        if ($request->file('data.Machine.cartrecto')) {
            $cartrectoPath = $this->handleImage($request->file('data.Machine.cartrecto'));
            $dossier->cartegrise_recto = $cartrectoPath;
        }
    
        if ($request->file('data.Machine.cartverso')) {
            $cartversoPath = $this->handleImage($request->file('data.Machine.cartverso'));
            $dossier->cartegrise_recto = $cartversoPath;
        }
    
        $dossier->save();
    
        // Handle the creation of related PartieDossier entries
        foreach ($request->all() as $key => $value) {
            $id = explode('_', $key)[0];
    
            if ($id !== 'null' && strpos($key, '_report') !== false && $request->input($id . '_damage') !== null) {
    
                if (!empty($request->input($id . '_damage'))) {
    
                    // Initialize $newFilename to null
                    $newFilename = null;
    
                    // Check if a file is present and handle it
                    if ($request->hasFile('frontCard_' . $id)) {
                        $file = $request->file('frontCard_' . $id);
    
                        // Call a method to handle the image upload
                        $newFilename = $this->handleImageDamage($file);
                    }
    
                    // Create a new DossierPartie instance
                    $partieDossier = new DossierPartie();
                    $partieDossier->dossier()->associate($dossier);
    
                    // Find the corresponding Partie
                    $part = Partie::find($id);
                    $partieDossier->partie()->associate($part);
    
                    // Set damage and image filename
                    $partieDossier->damage = $request->input($id . '_damage');
                    $partieDossier->damage_image = $newFilename;
    
                    // Save the DossierPartie instance
                    $partieDossier->save();
                }
            }
        }
    
        return redirect()->route('dossiers')->with('success', 'Dossier ajouté avec succès.');
    }
    




    //Carte Grise photos Storage
    protected function handleImage($image)
    {
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('assets/images/CarteGrise'), $name_gen);
        $imagePath = 'assets/images/CarteGrise/' . $name_gen;
        return $imagePath;
    }

    //Damgae photos Storage
    protected function handleImageDamage($image)
    {
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('assets/images/Damages'), $name_gen);
        $imagePath = 'assets/images/Damages/' . $name_gen;
        return $imagePath;
    }


    /////////////////////////: etapes

    public function etapes()
    {

        $data = Etapes::all();
        $orders = Orders::all();
        return view('etapes', compact(['data', 'orders']));
    }

    public function createEtape(Request $request)
    {
        $etape = new Etapes();
        $etape->name = $request['etape_name'];
        $etape->save();

        foreach ($request['questions'] as $question) {
            $newQues = new Questions();
            $newQues->name = $question;
            $newQues->etape_id = $etape->id;
            $newQues->save();
        }

        return redirect()->back();
    }

    public function orderEtape(Request $request)
    {
        $order = new Orders();
        $order->orders = $request['order_etapes'];
        $order->save();

        return redirect()->back();
    }

    public function details($id)
    {

        $dossier = Dossier::find($id);
        $pieces = Piece::all();

        return view('details', compact('dossier','pieces'));
    }




    public function SearchIndex(Request $request)
    {
        $query = $request->input('query');
        $userId = auth()->user()->id;

        $dossiers = Dossier::where('registration_number', 'LIKE', "%$query%")
            ->orWhere('previous_registration', 'LIKE', "%$query%")
            ->orWhere('first_registration', 'LIKE', "%$query%")
            ->orWhere('MC_maroc', 'LIKE', "%$query%")
            ->orWhere('usage', 'LIKE', "%$query%")
            ->orWhere('owner', 'LIKE', "%$query%")
            ->orWhere('address', 'LIKE', "%$query%")
            ->orWhere('validity_end', 'LIKE', "%$query%")
            ->orWhere('type', 'LIKE', "%$query%")
            ->orWhere('genre', 'LIKE', "%$query%")
            ->orWhere('fuel_type', 'LIKE', "%$query%")
            ->orWhere('chassis_nbr', 'LIKE', "%$query%")
            ->orWhere('cylinder_nbr', 'LIKE', "%$query%")
            ->orWhere('fiscal_power', 'LIKE', "%$query%")
            ->orWhereHas('modele', function ($q) use ($query) {
                $q->whereHas('marque', function ($q2) use ($query) {
                    $q2->where('name', 'LIKE', "%$query%");
                });
            })->where('user_id', $userId)
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
            'colors' => $colors,
        ]);
    }
    
}
