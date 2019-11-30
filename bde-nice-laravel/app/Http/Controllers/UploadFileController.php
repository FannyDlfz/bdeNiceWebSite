<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UploadFileController extends Controller
{
    function index()
    {
        return view('upload');
    }

    function upload(Request $request)
    {
        try {
            $this->validate($request, [
                'select-file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
        } catch (ValidationException $e) {
        }
        $image = $request->file('select_file');
        $new_name = rand().'.'. $image->getClientOriginalExtension();
        $image->move(public_path('image'), $new_name);

        return back()->with('success', 'Image Uploaded Successfully')->with('path', $new_name);

    }
}
