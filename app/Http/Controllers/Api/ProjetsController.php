<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Projet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjetsController extends Controller
{
    //
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'duree' => 'required|integer|min:0',
            'description' => 'required|string',
        ]);
        $projet = new Projet();
        $projet->name = $request->name;
        $projet->duree = $request->duree;
        $projet->etudiant_id = Auth::user()->id;
        $projet->description = $request->description;
        $projet->save();
        return response()->json([
            'status' => 1,
            'message' => 'Projet created successfully',
            'projet' => $projet
        ], 201);
    }
    public function delete( $id)
    {
        $etudiant_id = Auth::user()->id;
        if (!Projet::where('id', $id)->where('etudiant_id', $etudiant_id)->exists()) {
            return response()->json([
                'status' => 0,
                'message' => 'Projet not found'
            ], 404);
        }
        $projet = Projet::where('id', $id)->where('etudiant_id', $etudiant_id)->first();
        $projet->delete();
        return response()->json([
            'status' => 1,
            'message' => 'Projet deleted successfully'
        ], 200);

    }
    public function list()
    {
        $etudiant_id = Auth::user()->id;
        $projets = Projet::where('etudiant_id', $etudiant_id)->get();
        return response()->json([
            'status' => 1,
            'message' => 'Projets found',
            'projets' => $projets
        ], 200);

    }
    public function details( $id)
    {
        $etudiant_id = Auth::user()->id;
        $projet = Projet::where('id', $id)->where('etudiant_id', $etudiant_id)->get();
        if (!Projet::where('id', $id)->where('etudiant_id', $etudiant_id)->exists()) {
            return response()->json([
                'status' => 0,
                'message' => 'Projet not found'
            ], 404);
        }
        return response()->json([
            'status' => 1,
            'message' => 'Projet found',
            'projet' => $projet
        ], 200);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'string|max:255',
            'duree' => 'integer|min:0',
            'description' => 'string',
        ]);
        $etudiant_id = Auth::user()->id;
        if (!Projet::where('id', $id)->where('etudiant_id', $etudiant_id)->exists()) {
            return response()->json([
                'status' => 0,
                'message' => 'Projet not found'
            ], 404);
        }
        $projet = Projet::where('id', $id)->where('etudiant_id', $etudiant_id)->first();
        if ($request->name) {
            $projet->name = $request->name;
        }
        if ($request->duree) {
            $projet->duree = $request->duree;
        }
        if ($request->description) {
            $projet->description = $request->description;
        }
        $projet->save();
        return response()->json([
            'status' => 1,
            'message' => 'Projet updated successfully',
            'projet' => $projet
        ], 200);

    }
}
