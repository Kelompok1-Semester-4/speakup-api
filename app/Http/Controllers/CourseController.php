<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{

    public function index(Request $request)
    {

        $id = $request->input('id');
        $course_type_id = $request->input('course_type_id');
        $name = $request->input('name');

        if($name) {
            $courses = Course::with(['detailCourse','detailUser'])->where('name', 'like', '%' . $name . '%')->get();
            return $courses;
        }

        if($id) {
            return Course::with(['detailCourse', 'detailUser'])->find($id);
        }

        if($course_type_id) {
            return Course::with(['detailCourse', 'detailUser'])->where('course_type_id', $course_type_id)->get();
        }

        $course = Course::with(['courseType', 'detailUser', 'detailCourse'])->get();
        return response()->json($course);
    }
}
