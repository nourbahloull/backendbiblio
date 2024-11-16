<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use App\Models\Rapport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RapportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $rapports=Rapport::with('rapport')->get(); // Inclut la filiere liée;
            return response()->json($rapports,200);
            } catch (\Exception $e) {
            return response()->json("Sélection impossible {$e->getMessage()}");
            }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $rapport=new Rapport([
            "titre"=>$request->input("titre"),
            "description"=>$request->input("description"),
            "filiere_id"=>$request->input("filiere_id")
            ]);
            $rapport->save();
            return response()->json($rapport);
            
            
            
            } catch (\Exception $e) {
            return response()->json("insertion impossible {$e->getMessage()}");
            }
    }

    /**
     * Display the specified resource.
     */
    public function show(Rapport $rapport,$id)
    {
        try {
            $rapport=Rapport::with('rapport')->findOrFail($id);
            return response()->json($rapport);
            } catch (\Exception $e) {
            return response()->json("Sélection impossible {$e->getMessage()}");
            }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rapport $rapport,$id)
    {
        try {
            $rapport=Rapport::findorFail($id);
            $rapport->update($request->all());
            return response()->json($rapport);
            } catch (\Exception $e) {
            return response()->json("Modification impossible {$e->getMessage()}");
            }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rapport $rapport,$id)
    {
        try {
            $rapport=Rapport::findOrFail($id);
            $rapport->delete();
            return response()->json("Rapport supprimé avec succes");
            } catch (\Exception $e) {
            return response()->json("Suppression impossible {$e->getMessage()}");
            }
    }
    //Ajouter la méthode qui permet de récupérer la liste des rapports pour une filiere donnée
    public function showRapportByFIL($idfil)
{
try {
$rapports= Rapport::where('filiere_id', $idfil)->with('filiere')->get();
return response()->json($rapports);
} catch (\Exception $e) {
return response()->json("Selection impossible {$e->getMessage()}");
}
}
public function rapportsPaginate()
{
try {
$perPage = request()->input('pageSize', 2);
// Récupère la valeur dynamique pour la pagination
$rapports = Rapport::with('filiere')->paginate($perPage);
// Retourne le résultat en format JSON API
return response()->json([
'products' => $rapports->items(), // Les rapports paginés
'totalPages' => $rapports->lastPage(), // Le nombre de pages
]);
} catch (\Exception $e) {
return response()->json("Selection impossible {$e->getMessage()}");
}
}
public function search(Request $request)
{
    $keyword = $request->input('keyword');
    $filiereId = $request->input('filiere_id');

    // Construction de la requête de recherche
    $query = Rapport::query();

    // Filtrer par mot-clé si fourni
    if ($keyword) {
        $query->where('title', 'like', '%' . $keyword . '%')
              ->orWhere('content', 'like', '%' . $keyword . '%');
    }

    // Filtrer par filière si sélectionnée
    if ($filiereId) {
        $query->where('filiere_id', $filiereId);
    }

    // Exécuter la requête et obtenir les résultats
    $rapports = $query->get();

    // Renvoyer les résultats avec les filières pour le formulaire de recherche
    $filieres = Filiere::all();

    return view('rapports.index', compact('rapports', 'filieres'));
}
public function download($id)
{
    $rapport = Rapport::find($id);

    if (!$rapport) {
        return response()->json(['message' => 'Rapport non trouvé'], 404);
    }

    $filePath = $rapport->file_path; // Assurez-vous que `file_path` contient le chemin d'accès complet au fichier

    if (!Storage::exists($filePath)) {
        return response()->json(['message' => 'Fichier non disponible'], 404);
    }

    return Storage::download($filePath);
}
public function getRapportsByFiliere($filiereId)
{
    $filiere = Filiere::with('rapports')->find($filiereId);
    if (!$filiere) {
        return response()->json(['message' => 'Filière non trouvée'], 404);
    }
    return response()->json($filiere);
}

}
