<?php

namespace App\Http\Controllers\Note;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function updateNote(Request $request, $id)
    {
        try {
            $note = Note::findOrFail($id);
            $note->title = $request->title;
            $note->content = $request->content;
            $note->save();

            return redirect()->route('stickynote.page')->with('result', 'Note Updated successfully');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
