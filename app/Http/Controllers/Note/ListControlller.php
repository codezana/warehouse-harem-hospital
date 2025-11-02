<?php

namespace App\Http\Controllers\Note;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;

class ListControlller extends Controller
{
    public function getUserNotes()
    {
        $user_id = auth()->user()->id;
        $notes = Note::where('user_id', $user_id)->get();
        return view('note.stickynote', compact('notes'));
    }

}
