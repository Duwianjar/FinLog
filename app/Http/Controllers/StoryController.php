<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Depository;
use App\Models\User;

use Illuminate\Support\Facades\File;

class StoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $depositoried = Depository::where('id_user', Auth::user()->id)->get();
        $user = Auth::user();
        $stories = story::all();
        return view('story.index', compact('depositoried', 'user', 'stories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'allow_comments' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'caption' => 'required|max:255',
        ]);

        $validatedData['id_user'] = Auth::user()->id;

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');

            // Pengecekan apakah file foto ada
            if ($photo->isValid()) {
                // Simpan foto baru dengan nama pengguna dan tanggal sebagai nama file
                $extension = $photo->getClientOriginalExtension();
                $currentDate = date('YmdHis');
                $fileName = Auth::user()->name . '_' . $currentDate . '.' . $extension;

                // Simpan foto ke dalam direktori public/assets/img/pp
                $photo->move(public_path('assets/img/story'), $fileName);

                // Simpan path foto ke dalam database
                $validatedData['photo'] = 'assets/img/story/' . $fileName;

                // Simpan perubahan pada objek pengguna
                Story::create($validatedData);

                return redirect()->back()->with('success-story', 'Story berhasil dibuat.');
            } else {
                return "gagal Mengunggah foto, silahkan upload foto yang benar";
            }
        } else {
            $validatedData['photo'] = '';
            Story::create($validatedData);
            return redirect()->back()->with('success-story', 'Story berhasil dibuat.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Story $story)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Story $story)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Story $story)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Story $story)
    {
        //
    }
}