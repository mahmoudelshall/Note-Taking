<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Notes",
 *     description="Endpoints related to Notes"
 * )
 */
class NoteController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/notes",
     *     summary="Get all notes for the logged in user",
     *     tags={"Notes"},
     *     security={ {"bearerAuth": {}} },
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Note")
     *     )
     * )
     */
    public function index()
    {
        $notes = Note::where('user_id', Auth()->user()->id)->get();
        return response()->json(['notes' => $notes], 200);
    }

   /**
     * @OA\Post(
     *     path="/api/notes",
     *     summary="Create a new note for the logged in user",
     *     tags={"Notes"},
     *     security={ {"bearerAuth": {}} },
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/NewNote")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Created",
     *         @OA\JsonContent(ref="#/components/schemas/Note")
     *     )
     * )
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
     * @OA\Get(
     *     path="/api/notes/{id}",
     *     summary="Get a specific note for the logged in user",
     *     tags={"Notes"},
     *     security={ {"bearerAuth": {}} },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Note")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     )
     * )
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
     * @OA\Put(
     *     path="/api/notes/{id}",
     *     summary="Update a specific note for the logged in user",
     *     tags={"Notes"},
     *     security={ {"bearerAuth": {}} },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/UpdateNote")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Note")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     )
     * )
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
     * @OA\Delete(
     *     path="/api/notes/{id}",
     *     summary="Delete a specific note for the logged in user",
     *     tags={"Notes"},
     *     security={ {"bearerAuth": {}} },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Deleted"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     )
     * )
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
