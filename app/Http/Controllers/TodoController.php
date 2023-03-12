<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Todo::get();



        return view('todos.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('todos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'libelle' => 'required',
        ]);

        try {

            // methode 1
            $todo1              = new Todo();
            $todo1->libelle     =  $request->libelle;
            $todo1->description =  $request->description;
            $todo1->user_id     =  $request->user_id;
            $todo1->save();


            // Methode2 et  conseillé
            $todo2 = Todo::create([
                'libelle'       => $request->libelle,
                'description'   => $request->description,
                'user_id'       => $request->user_id,
            ]);

            $message = "Todo enregistrer avec success";

            return redirect()->route('todos.index')->with('message');
        } catch (Exception $e) {
            $message = "Erreeru d'enregistrement";
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = Todo::find($id);
        return view('todos.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Todo::find($id);
        return view('todos.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required',
            'libelle' => 'required',
        ]);


        try {
            $update = [
                'libelle'       => $request->libelle,
                'description'   => $request->description,
                'user_id'       => $request->user_id,
            ];

            Todo::where('id', $id)->update($update);
            $message = "Todo modifier avec success";
            return redirect()->route('todos.index')->with('message');
        } catch (Exception $e) {
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $data = Todo::find($id);
            $data->delete();
        } catch (Exception $e) {
            return back();
        }
    }
}
