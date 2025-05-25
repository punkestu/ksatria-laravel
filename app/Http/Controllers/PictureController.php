<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PictureController extends Controller
{
    /**
     * Store a newly created resource in storage as API
     */
    public function storeApi(Request $request)
    {
        $validation = validator($request->all(), [
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'fileurl' => 'required_if:file,null',
        ], [
            'file.required' => 'The file field is required when file URL is not provided.',
            'fileurl.required_if' => 'The file URL field is required when file is not provided.',
            'file.image' => 'The file must be an image.',
            'file.mimes' => 'The file must be a type of jpeg, png, jpg, gif, or svg.',
            'file.max' => 'The file may not be greater than 2048 kilobytes.',
            'fileurl.url' => 'The file URL must be a valid URL.',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }

        $picture = new Picture();
        if ($request->hasFile('file')) {
            $picture->url = '/storage/' . $request->file('file')->store('pictures', 'public');
        } else {
            $picture->url = $request->input('fileurl');
        }
        $picture->name = 'Picture_T' . time() . 'R' . random_int(1000, 9999);
        $picture->user_id = Auth::id(); // Assuming the user is authenticated

        $picture->save();

        return response()->json([
            'message' => 'Picture uploaded successfully',
            'data' => $picture,
        ], 201);
    }

    /**
     * Get all pictures as API
     */
    public function getAllPicturesApi()
    {
        $pictures = Picture::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')->get();

        return response()->json([
            'message' => 'Pictures retrieved successfully',
            'data' => $pictures,
        ], 200);
    }

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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Picture $picture)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Picture $picture)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Picture $picture)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Picture $picture)
    {
        //
    }
}
