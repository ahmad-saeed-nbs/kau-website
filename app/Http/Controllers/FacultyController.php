<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    public function index(Request $request)
    {
        $language = $request->get('lang', 'en');

        $faculties = Faculty::where('language', $language)->get();

        return view('faculty.index', compact('faculties', 'language'));
    }

    public function profile($lang, $faculty)
    {
        $facultyData = Faculty::where('language', $lang)
            ->where('code', $faculty)
            ->firstOrFail();

        return view('faculty.profile', [
            'lang'    => $lang,
            'faculty' => $facultyData,
        ]);
    }
}
