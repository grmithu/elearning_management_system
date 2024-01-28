<?php

namespace App\Http\Controllers;

use App\Models\Library;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Termwind\Components\Li;

class LibraryController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        if (!auth()->user() || auth()->user()->type != 'admin')
            return abort(401);

        return view('library.create');
    }

    public function store(Request $request)
    {
        if($request->thumbnail) {
            $tmpName = str_replace(' ', '_', $request->thumbnail->getClientOriginalName());
            $thumbnailName = time().'_'.$tmpName;
            if(env('APP_ENV') == 'local') {
                $request->thumbnail->move(public_path('images/libraries'), $thumbnailName);
            } else {
                $request->thumbnail->move('images/libraries', $thumbnailName);
            }
        } else {
            $thumbnailName = "default.jpg";
        }

        if($request->library_file) {
            $tmpName = str_replace(' ', '_', $request->library_file->getClientOriginalName());
            $fileName = time().'_'.$tmpName;
            $request->library_file->storeAs('public/libraries/resources', $fileName);
        } else {
            $fileName = null;
        }

        Library::create([
            'title'         => $request->title,
            'description'   => $request->description,
            'thumbnail'     => $thumbnailName,
            'file'          => $fileName,
        ]);

        return redirect()->route('home');
    }

    public function destroy(Library $library)
    {
        if (!auth()->user() || auth()->user()->type != 'admin')
            return abort(401);

        $library->delete();

        return back();
    }

    public function resourceDownload($file_name)
    {
        if(env('APP_ENV') == 'local') {
            $filePath = 'public/libraries/resources/' . $file_name;
            $fileUrl = Storage::url($filePath);

            return response()->download(public_path($fileUrl), $file_name);
        } else {
            $filePath = 'storage/libraries/resources/' . $file_name;
            return response()->download($filePath, $file_name);
        }
    }
}
