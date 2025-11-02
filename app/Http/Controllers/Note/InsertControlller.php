<?php

namespace App\Http\Controllers\Note;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;

class InsertControlller extends Controller
{
     //Home Page 

     public function home()
     {
         $notes = Note::where('user_id', auth()->user()->id)->get();
         return view('note.stickynote', compact('notes'));
     }
 
     
     public function addNote(Request $request)
     {
         $request->validate([
             'title' => 'required',
             'content' => 'required',
         ]);
 
         try {
             $note = new Note();
             $note->title = $request->title;
             $note->content = $request->content;
             $note->user_id = auth()->user()->id; // Associate the note with the current user
             $note->save();
             return redirect()->route('stickynote.page')->with('result', 'Note created successfully');
         } catch (\Exception $e) {
             return response()->json(['error' => $e->getMessage()], 500);
         }
     }
 
 
}
