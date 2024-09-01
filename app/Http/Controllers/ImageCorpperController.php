<?php

namespace App\Http\Controllers;

use App\Models\ImageCropper;
use Illuminate\Http\Request;

class ImageCorpperController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function uploadImage(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Check if the image file is present in the request
        if ($request->file('image')) {
            $image = $request->file('image');
            
            // Generate a unique name for the image using the current timestamp and its extension
            $imageName = time() . '.' . $image->extension();

            // Move the uploaded image to the public/images directory
            $image->move(public_path('images'), $imageName);

            // Return a JSON response with success message and image name
            return response()->json(['success' => 'Image uploaded successfully.', 'image_name' => $imageName]);
        }

        // If no image is found in the request, return an error message
        return response()->json(['error' => 'Image upload failed.'], 400);
    }
}
