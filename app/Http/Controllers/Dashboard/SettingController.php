<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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
                'welcome_video' => 'required|string|url',
            ],
            [
                'welcome_video.required' => 'Video selamat datang harus diisi.',
                'welcome_video.string' => 'Video selamat datang harus berupa string.',
                'welcome_video.url' => 'Video selamat datang harus berupa URL yang valid.',
            ]
        );

        if ($validation->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validation->errors()->first(),
                'errors' => $validation->errors(),
            ], 422);
        }

        $youtubeId = Setting::get_youtube_id($request->input('welcome_video'));
        $path = 'https://www.youtube.com/embed/' . $youtubeId;

        Setting::updateOrCreate(
            ['id' => 1], // Assuming there's only one setting record
            ['welcome_video' => $path]
        );

        Cache::forget('settings'); // Clear the cache for settings

        return response()->json([
            'status' => 'success',
            'message' => 'Video selamat datang berhasil diperbarui.',
            'data' => [
                'path' => $path,
            ],
        ]);
    }
}
