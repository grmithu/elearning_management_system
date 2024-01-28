<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Department;
use App\Models\Course;
use App\Models\Gallery;
use App\Models\Library;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index ()
    {
        // if (Auth::check()) return redirect(route('dashboard'));

        $instructors = User::WHERE('type', 'instructor')->get();
        $courses = Course::get();
        $departments = Department::get();
        $galleries = Gallery::get();
        $blogs = Blog::with('user')->orderBy('created_at', 'Desc')->take(4)->get();
        $libraries = Library::orderBy('created_at', 'desc')->get();

        return view('landing-page.index', compact('courses', 'instructors', 'departments', 'galleries', 'blogs', 'libraries'));
    }

    public function landing ()
    {
        $instructors = User::WHERE('type', 'instructor')->get();
        $courses = Course::get();
        $departments = Department::get();
        $galleries = Gallery::get();
        $blogs = Blog::with('user')->orderBy('created_at', 'Desc')->take(4)->get();
        $libraries = Library::orderBy('created_at', 'desc')->get();

        return view('landing-page.index', compact('courses', 'instructors', 'departments', 'galleries', 'blogs', 'libraries'));
    }
}
