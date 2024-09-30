<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    try {
        // Cek input
        $request->validate([
            'id_user' => 'required|integer',
            'id_story' => 'required|integer',
            'like_type' => 'required|string',
        ]);

        // Cek apakah user sudah menyukai postingan
        $like = Like::where('id_user', $request->input('id_user'))
                    ->where('id_story', $request->input('id_story'))
                    ->first();

        if ($like) {
            // Jika user sudah menyukai postingan, hapus like
            $like->delete();
            return response()->json(['message' => 'Like dihapus'], 200);
        } else {
            // Jika user belum menyukai postingan, buat like baru
            $like = new Like();
            $like->id_user = $request->input('id_user');
            $like->id_story = $request->input('id_story');
            $like->like_type = $request->input('like_type');

            try {
                // Try to save the Like model
                $like->save();
                return response()->json(['message' => 'Like berhasil'], 201);
            } catch (\Illuminate\Database\QueryException $e) {
                // Catch database query exceptions
                return response()->json(['message' => 'Error saving like', 'errors' => $e->getMessage()], 500);
            }
        }
    } catch (\Illuminate\Validation\ValidationException $e) {
        // Return a 422 Unprocessable Entity status code for validation errors
        return response()->json(['message' => 'Validation error', 'errors' => $e->getMessage()], 422);
    } catch (\Exception $e) {
        // Return a 500 Internal Server Error status code for other exceptions
        return response()->json(['message' => 'Internal Server Error'], 500);
    }
}
    /**
     * Display the specified resource.
     */
    public function show(Like $like)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Like $like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Like $like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Like $like)
    {
        //
    }
}