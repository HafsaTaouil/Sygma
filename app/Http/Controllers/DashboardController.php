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
        // Validate incoming request data
        // $request = $request->validate([
        //     'data.Machine.num_imma' => 'required|string|max:255',
        //     'data.Machine.num_imma_ante' => 'nullable|string|max:255',
        //     'data.Machine.date_mc' => 'required|date_format:d/m/Y',
        //     'data.Machine.date_mc_maroc' => 'required|date_format:d/m/Y',
        //     'data.Machine.v_usage' => 'required|string|max:255',
        //     'data.Machine.name' => 'required|string|max:255',
        //     'data.Machine.adresse' => 'required|string|max:255',
        //     'data.Machine.fin_valide' => 'required|date_format:d/m/Y',
        //     'data.Machine.marque' => 'required|string|max:255',
        //     'data.Machine.modele' => 'required|string|max:255',
        //     'data.Machine.type' => 'required|string|max:255',
        //     'data.Machine.genre' => 'required|string|max:255',
        //     'data.Machine.type_carburant' => 'required|string|max:255',
        //     'data.Machine.n_chassis' => 'required|string|max:255',
        //     'data.Machine.n_cylindres' => 'nullable|string|max:255',
        //     'data.Machine.puissance' => 'nullable|string|max:255',
        //     'data.Machine.cartrecto' => 'nullable|image|max:2048',
        //     'data.Machine.cartverso' => 'nullable|image|max:2048',
        //     'data.Machine.debut_annee' => 'nullable|string|max:255',
        //     'data.Machine.n_fiscalite' => 'nullable|string|max:255',
        //     'data.Machine.cotisation' => 'nullable|string|max:255',
        //     'data.Machine.photo_dommage' => 'nullable|image|max:2048',
        //     'data.Machine.gravite_dommage' => 'nullable|string|in:Léger,Modéré,Grave',
        // ]);


        // dd($request);
        //    dd($request->all());
        // Create and save the Model and Mark
        // if (!isset($request['data']['Machine']['modele'])) {
        //     return redirect()->back()->withErrors(['modele' => 'Modele is required.']);
        // }
        $model = new Modele();
        //$model->name = $request['data']['Machine']['modele'];
        $model->name = ucwords(strtolower($request['data']['Machine']['modele']));

        $marqueName = ucwords(strtolower($request['data']['Machine']['marque']));
        $mark = Marque::firstOrCreate(['name' => $marqueName]);
        $model->marque_id = $mark->id;
        $model->save();

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

        $dateString = $request['data']['Machine']['date_mc'];
        $date = DateTime::createFromFormat('d-M-Y', $dateString);

        if (!$date) {
            // Log the error for debugging
            error_log("Date parsing failed for: $dateString");
            // Use a default value to satisfy the non-null constraint
            $dossier->first_registration = '1970-01-01'; // Or another appropriate default date
        } else {
            $dossier->first_registration = $date->format('Y-m-d');
        }
        // $dossier->first_registration = new Carbon($request['data']['Machine']['date_mc']);
        $dateString1 = $request['data']['Machine']['date_mc_maroc'];
        $date1 = DateTime::createFromFormat('d-M-Y', $dateString1);

        if (!$date1) {
            // Log the error for debugging
            error_log("Date parsing failed for: $dateString1");
            // Use a default value to satisfy the non-null constraint
            $dossier->MC_maroc = '1970-01-01'; // Or another appropriate default date
        } else {
            $dossier->MC_maroc = $date1->format('Y-m-d');
        }


        // $dossier->mc_maroc = new Carbon($request['data']['Machine']['date_mc_maroc']);
        $dateString2 = $request['data']['Machine']['fin_valide'];
        $date2 = DateTime::createFromFormat('d-M-Y', $dateString2);

        if (!$date2) {
            // Log the error for debugging
            error_log("Date parsing failed for: $dateString2");
            // Use a default value to satisfy the non-null constraint
            $dossier->validity_end = '1970-01-01'; // Or another appropriate default date
        } else {
            $dossier->validity_end = $date2->format('Y-m-d');
        }


        // $dossier->validity_end = new Carbon($request['data']['Machine']['fin_valide']);
        $dossier->genre = $request['data']['Machine']['genre'];
        $dossier->owner = $request['data']['Machine']['name'];
        $dossier->fuel_type = $request['data']['Machine']['type_carburant'];
        $dossier->user_id = auth()->user()->id;

        // dd($dossier->user_id)

        $dossier->save();

        // Handle file uploads for the Dossier
        // if ($request->hasFile('data.Machine.cartrecto')) {
        //     $cartrectoPath = $request->file('data.Machine.cartrecto')->store('cartegrise', 'public');
        //     $dossier->cartegrise_recto = $cartrectoPath;
        // }

        if ($request->file('data.Machine.cartrecto')) {
            $cartrectoPath = $this->handleImage($request->file('data.Machine.cartrecto'));
            $dossier->cartegrise_recto = $cartrectoPath;
        }

        // if ($request->hasFile('data.Machine.cartverso')) {
        //     $cartversoPath = $request->file('data.Machine.cartverso')->store('cartegrise', 'public');
        //     $dossier->cartegrise_verso = $cartversoPath;
        // }


        if ($request->file('data.Machine.cartverso')) {
            $cartversoPath = $this->handleImage($request->file('data.Machine.cartverso'));
            $dossier->cartegrise_recto = $cartversoPath;
        }

        // Save Dossier entry
        $dossier->save();

        // Handle the creation of related PartieDossier entries
        foreach ($request->all() as $key => $value) {
            $id = explode('_', $key)[0];

            if ($id !== 'null' && strpos($key, '_report') !== false && $request->input($id . '_damage') !== null) {

                if (!empty($request->input($id . '_damage'))) {

                    // Initialize $newFilename to null
                    $newFilename = null;

                // $newFilename = $request->file('frontCard_' . $id)->store('dommages', 'public');


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

        return view('details', compact('dossier'));
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
