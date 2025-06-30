<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResourceController extends Controller
{
    /**
     * Store a newly created resource in storage as API
     */
    public function storeApi(Request $request)
    {
        $validation = validator($request->all(), [
            'file' => 'nullable|max:10480',
            'fileurl' => 'required_if:file,null',
        ], [
            'file.required' => 'The file field is required when file URL is not provided.',
            'fileurl.required_if' => 'The file URL field is required when file is not provided.',
            'file.max' => 'The file may not be greater than 10 MB.',
            'fileurl.url' => 'The file URL must be a valid URL.',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }

        $resource = new Resource();
        if ($request->hasFile('file')) {
            $resource->url = '/storage/' . $request->file('file')->store('pictures', 'public');
            $resource->type = $request->file('file')->getClientMimeType();
            $resource->name = $request->file('file')->getClientOriginalName();
        } else {
            $resource->url = $request->input('fileurl');
            $resource->type = 'url';
            $resource->name = 'Resource_T' . time() . 'R' . random_int(1000, 9999);
        }
        $resource->user_id = Auth::id(); // Assuming the user is authenticated
        $resource->description = $request->input("description", "-");
        $resource->alt_text = $request->input("alt_text", $resource->name);

        $resource->save();

        return response()->json([
            'message' => 'Resource uploaded successfully',
            'data' => $resource,
        ], 201);
    }

    /**
     * Get all pictures as API
     */
    public function getAllResourcesApi()
    {
        $resources = Resource::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')->get();

        return response()->json([
            'message' => 'Resources retrieved successfully',
            'data' => $resources,
        ], 200);
    }
}
