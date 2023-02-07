<?php

namespace App\Http\Controllers;

use App\Models\Fileupload;
use Illuminate\Http\Request;

class FileuploadController extends Controller
{
    public function create()
    {
        $files = Fileupload::all();
        return view('fileupload', ['files' => $files]);
    }

    public function store(Request $request)
    {
        $formFields = [];
        if($request->hasFile('path')){
            $formFields['path'] = $request->file('path')->store('fileuploads', 'public');
            $formFields['user_id'] = auth()->user()->id;
            Fileupload::create($formFields);
        }

        return redirect()->route('fileupload_create');
    }
}
