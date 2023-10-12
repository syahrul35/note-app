<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\NotesResource;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class NotesController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notes = Note::all();
        return $this->sendResponse(NotesResource::collection($notes), 'Notes Berhasil Dimuat');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'desc' => 'required',
            'user_id' => 'required'
        ]);
        

        if($validator->fails()){
            return $this->sendError('Validation Error', $validator->errors());
        }

        $notes = Note::create($input);

        return $this->sendResponse(new NotesResource($notes), 'Note Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $note = Note::find($id);
  
        if (is_null($note)) {
            return $this->sendError('Note not found.');
        }
   
        return $this->sendResponse(new NotesResource($note), 'Note Berhasil Dipilih.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note): JsonResponse
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'title' => 'required',
            'desc' => 'required',
            'user_id' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $note->title = $input['title'];
        $note->desc = $input['desc'];
        $note->user_id = $input['user_id'];
        $note->save();
   
        return $this->sendResponse(new NotesResource($note), 'Note updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note): JsonResponse
    {
        $note->delete();
   
        return $this->sendResponse([], 'Note deleted successfully.');
    }
}
