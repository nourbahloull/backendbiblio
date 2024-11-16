<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Filiere;
use Illuminate\Http\Request;

class FiliereController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $filieres=Filiere::all();
            return response()->json($filieres);
            } catch (\Exception $e) {
            return response()->json("probleme de récupération de la liste des filieres");
            }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $filiere=new Filiere([
            "nomFiliere"=>$request->input("nomFiliere"),
            ]);
            $filiere->save();
            
            
            return response()->json($filiere);
            
            } catch (\Exception $e) {
            return response()->json("insertion impossible");
            }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $filiere=Filiere::findOrFail($id);
            return response()->json($filiere);
            } catch (\Exception $e) {
            return response()->json("probleme de récupération des données");
            }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $filiere=Filiere::findorFail($id);
            $filiere->update($request->all());
            return response()->json($filiere);
            } catch (\Exception $e) {
            return response()->json("probleme de modification $e-> {getMessage()},{getCode()}");
            }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $filiere=Filiere::findOrFail($id);
            $filiere->delete();
            return response()->json("filiere supprimée avec succes");
            } catch (\Exception $e) {
            return response()->json("probleme de suppression de filiere");
            }
    }
    public function getRapports($id)
    {
        // Récupérer la filière par son ID
        $filiere = Filiere::with('rapports')->find($id);

        // Vérifier si la filière existe
        if (!$filiere) {
            return response()->json(['message' => 'Filière introuvable'], 404);
        }

        // Renvoyer les rapports associés
        return response()->json($filiere->rapports, 200);
    }
}
