<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AppSettingController extends Controller
{
    public function index(): View
    {
        return view('admin.setting.index');
    }

    public function update(Request $request): JsonResponse
    {
        $settings = AppSetting::firstOrFail();

        // Validate input
        $validatedData = $request->validate([
            'app_name' => 'required|string|max:255',
            'app_description' => 'nullable|string',
            'app_logo' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048', // max size 2MB
        ]);

        // Handle file upload
        if ($request->hasFile('app_logo')) {
            if ($settings->app_logo && $settings->app_logo !== 'images/logos/logo.png') {
                Storage::disk('public')->delete($settings->app_logo);
            }

            $path = $request->file('app_logo')->store('images/logos', 'public');
            $validatedData['app_logo'] = str_replace('public/', '', $path);
        }

        // Update settings
        $settings->update($validatedData);

        return response()->json(['message' => 'Settings updated successfully.']);
    }

}
