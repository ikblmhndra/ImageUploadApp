<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Image;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $file = $request->file('image');

        $image = new Image();
        $image->user_id = Auth::id();
        $image->filename = $file->getClientOriginalName();
        $image->mime = $file->getClientMimeType();
        $image->data = file_get_contents($file->getRealPath());
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

        $image->delete();

        return redirect()->back()->with('success', 'Image deleted successfully!');
    }

    public function showImage($id)
    {
        $image = Image::findOrFail($id);

        if ($image->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return response($image->data, 200)
            ->header('Content-Type', $image->mime)
            ->header('Content-Disposition', 'inline; filename="'.$image->filename.'"');
    }
}
