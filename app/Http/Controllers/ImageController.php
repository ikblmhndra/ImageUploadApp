<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = $request->file('image')->store('images', 'public');

        $image = new Image();
        $image->user_id = Auth::id();
        $image->path = $path;
        $image->save();

        return redirect()->back()->with('success', 'Image uploaded successfully!');
    }

    public function gallery()
    {
        $images = Auth::user()->images ?? collect();
        return view('gallery', compact('images'));
    }

    public function delete($id)
    {
        $image = Image::findOrFail($id);

        if ($image->user_id != Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        Storage::disk('public')->delete($image->path);
        $image->delete();

        return redirect()->back()->with('success', 'Image deleted successfully!');
    }

    public function showImage($id)
    {
        $image = Image::findOrFail($id);

        if ($image->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $path = storage_path('app/public/' . $image->path);

        if (!file_exists($path)) {
            abort(404);
        }

        $file = file_get_contents($path);
        $type = mime_content_type($path);

        return response($file, 200)->header('Content-Type', $type);
    }
}
