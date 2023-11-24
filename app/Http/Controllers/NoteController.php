<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notes = Note::where('user_id', Auth()->user()->id)->get();
        return response()->json(['notes' => $notes], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        $note = Note::create([
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            // 'user_id' => Auth::id(),
            'user_id' => Auth()->user()->id
        ]);

        return response()->json(['note' => $note], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $note = Note::where('user_id', Auth()->user()->id)->find($id);

        if (!$note) {
            return response()->json(['error' => 'Note not found.'], 404);
        }

        return response()->json(['note' => $note], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $note = Note::where('user_id', Auth()->user()->id)->find($id);

        if (!$note) {
            return response()->json(['error' => 'Note not found.'], 404);
        }

        $request->validate([
            'title' => 'string',
            'content' => 'string',
        ]);

        $note->update([
            'title' => isset($request->title) ? $request->title : $note['title'],
            'content' => isset($request->content) ? $request->content : $note['content'],
        ]);

        return response()->json(['note' => $note], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $note = Note::where('user_id', Auth()->user()->id)->find($id);

        if (!$note) {
            return response()->json(['error' => 'Note not found.'], 404);
        }

        $note->delete();

        return response()->json(['message' => 'Note deleted successfully.'], 200);
    }
}
