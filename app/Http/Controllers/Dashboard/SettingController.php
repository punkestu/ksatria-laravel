<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return view('dashboard.setting.index');
    }

    public function update_welcome_video(Request $request)
    {
        $validation = validator(
            $request->all(),
            [
                'welcome_video' => 'required|file|mimes:mp4,mov,avi,flv|max:20480', // 20MB max
            ],
            [
                'welcome_video.required' => 'Video tidak boleh kosong.',
                'welcome_video.file' => 'File yang diunggah harus berupa video.',
                'welcome_video.mimes' => 'Format video yang diizinkan: mp4, mov, avi, flv.',
                'welcome_video.max' => 'Ukuran video tidak boleh lebih dari 20MB.',
            ]
        );

        if ($validation->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validation->errors()->first(),
                'errors' => $validation->errors(),
            ], 422);
        }

        $path = $request->file('welcome_video')->store('welcome_videos', 'public');

        Setting::updateOrCreate(
            ['id' => 1], // Assuming there's only one setting record
            ['welcome_video' => $path]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Video selamat datang berhasil diperbarui.',
            'data' => [
                'path' => $path,
            ],
        ]);
    }
}
