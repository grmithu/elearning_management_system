<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::orderBy('created_at', 'desc')
            ->with('user')
            ->paginate(20);

        return view('blogs.index', compact('blogs'));
    }

    public function create()
    {
        return view('blogs.create');
    }

    public function store(Request $request)
    {
        if($request->image) {
            $original_name = str_replace(' ', '_', $request->image->getClientOriginalName());
            $tmp_file_name = pathinfo($original_name, PATHINFO_FILENAME);
            $file_ext = $request->image->getClientOriginalExtension();
            $file_name = time().'_'.$tmp_file_name.'.'.$file_ext;

            if(env('APP_ENV') == 'local') {
                $request->image->move(public_path('images/blogs'), $file_name);
            }
            else {
                $request->image->move('images/blogs', $file_name);
            }
        } else
            $file_name = 'default.jpg';

        try {
            $blog = Blog::create([
                'headline'      => $request->headline,
                'content'       => $request->blog_content,
                'image'         => $file_name,
                'created_by'    => auth()->id()
            ]);

            return redirect()->route('blog.show', $blog->id);
        } catch (\Exception $exception) {
            return back();
        }
    }

    public function show(Blog $blog)
    {
        return view('blogs.show', compact('blog'));
    }

    public function edit(Blog $blog)
    {
        if (auth()->id() != $blog->created_by) return abort(401, 'Unauthorized');
        return view('blogs.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        if (auth()->id() != $blog->created_by) return back();
        if($request->image) {
            $original_name = str_replace(' ', '_', $request->image->getClientOriginalName());
            $tmp_file_name = pathinfo($original_name, PATHINFO_FILENAME);
            $file_ext = $request->image->getClientOriginalExtension();
            $file_name = time().'_'.$tmp_file_name.'.'.$file_ext;

            if(env('APP_ENV') == 'local') {
                $request->image->move(public_path('images/blogs'), $file_name);
            }
            else {
                $request->image->move('images/blogs', $file_name);
            }
        } else
            $file_name = $blog->image;

        try {
            $blog->update([
                'headline'      => $request->headline,
                'content'       => $request->blog_content,
                'image'         => $file_name,
            ]);

            return redirect()->route('blog.show', $blog->id);
        } catch (\Exception $exception) {
            return back();
        }
    }

    public function destroy(Blog $blog)
    {
        if (auth()->id() != $blog->created_by) return back();
        $blog->delete();
        return redirect()->route('blog.index');
    }
}
