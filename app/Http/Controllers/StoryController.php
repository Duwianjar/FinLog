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
        $stories = Story::latest()->paginate(5);
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
                return redirect('/story')->with('success-story', 'Story created successfully.');
            } else {
                return redirect('/story')->with('error-story', 'Failed to upload photo, please upload the correct photo.');
            }
        } else {
            $validatedData['photo'] = '';
            Story::create($validatedData);
            return redirect('/story')->with('success-story', 'Story created successfully.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $depositoried = Depository::where('id_user', Auth::user()->id)->get();
        $user = Auth::user();
        $story = Story::where('id', $id)->first();
        return view('story.detail', compact('depositoried', 'user', 'story'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        $depositoried = Depository::where('id_user', Auth::user()->id)->get();
        $user = Auth::user();

        $stories = Story::where(function ($query) use ($search) {
            $query->where('caption', 'like', '%' . $search . '%')
                ->orWhereIn('id_user', function ($query) use ($search) {
                    $query->select('id')
                        ->from('users')
                        ->where('name', 'like', '%' . $search . '%');
                });
        })->latest()->paginate(10);

        return view('story.index', compact('depositoried', 'user', 'stories'));
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
    public function update(Request $request, string $id)
    {

        $validatedData = $request->validate([
            'allow_comments' => 'required',
            'caption' => 'required|max:255'
        ]);

        $story = Story::findOrFail($id);

        if($story->caption == $validatedData ['caption']){
            $story->update($validatedData);
        } else {
            $validatedData['count_update']=$story->count_update +1;
            $story->update($validatedData);
        }

        return redirect('/story')->with('success-story', 'Story updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $story = Story::findOrFail($id);
        // Delete comments associated with the story
        $story->comments()->delete();
        $story->delete();

        return redirect('/story')->with('success-story', 'Story deleted successfully.');
    }
}