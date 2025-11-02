<?php

namespace App\Http\Controllers\Note;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;

class DeleteControlller extends Controller
{
    public function deleteNote($id)
    {
        try {
            $note = Note::findOrFail($id);
            $note->delete();

            return response()->json(['message' => 'Note deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


}
