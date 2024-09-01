<?php

namespace App\Http\Controllers;

use App\Models\PdfCompress;
use Illuminate\Http\Request;

class PdfCompressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->file('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images'), $imageName);

            return response()->json(['success' => 'Image uploaded successfully.', 'image_name' => $imageName]);
        }

        return response()->json(['error' => 'Image upload failed.']);
    }
}
