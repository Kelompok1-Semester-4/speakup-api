<?php

namespace App\Http\Controllers;

use App\Models\Diary;
use Illuminate\Http\Request;

class DiaryController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $diary_type_id = $request->input('diary_type_id');
        $search = $request->input('search');

        if($id) {
            return Diary::with(['diaryType', 'detailUser'])->find($id);
        }

        if($diary_type_id) {
            return Diary::with(['diaryType', 'detailUser'])->where('diary_type_id', $diary_type_id)->get();
        }

        if($search) {
            // multiple search query by title, content, detail_user.name
            return Diary::with(['diaryType', 'detailUser'])
                ->where('title', 'like', "%$search%")
                ->orWhereHas('detailUser', function($query) use ($search) {
                    $query->where('name', 'like', "%$search%");
                })
                ->get();
        }

        return Diary::with(['diaryType', 'detailUser'])->get();
    }
}
