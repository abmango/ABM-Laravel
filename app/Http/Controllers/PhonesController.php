<?php

namespace App\Http\Controllers;

use App\Models\Phones;
use App\Models\Persons;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PhonesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $personId = null)
    {
        $showDischarges = $request->input('discharges') == 'true';

        if ($showDischarges) {
            $phones = Phones::onlyTrashed()->get();
        } else {
            if ($personId) {
                $phones = Phones::where('person_id', $personId)->get();
            } else {
                $phones = Phones::all();
            }
        }

        $personName = $personId ? Persons::find($personId)->full_name : null;

        return view('phones.index', compact('phones', 'showDischarges', 'personId', 'personName'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('phones.entry');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        try {
        // Validar los datos entrantes
        $validatedData = $request->validate([
            'phone_number' => 'required|numeric|max_digits:11',
        ]);

        //dd($validatedData); // Muestra los datos enviados

        // Crear un nuevo celular en la base de datos
        Phones::create([
            'phone_number' => $validatedData['phone_number'],
        ]);

        // Redirigir a alguna ruta (como la lista de usuarios)
        return redirect()->route('phones.index')->with('success', 'Phone created successfully');
        } catch (\Exception $e) {
            // Mostrar el error
            dd($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $phone = Phones::findOrFail($id);
        $persons = Persons::all();
        
        return view('phones.modify', compact('phone', 'persons'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        try {
            $validatedData = $request->validate([
                'phone_number' => 'required|numeric|max_digits:11',
                'person_id' => 'required|exists:persons,id', // Asegurarse de que la persona existe
            ]);
    
            $phone = Phones::findOrFail($id);
            $phone->update([
                'phone_number' => $validatedData['phone_number'],
                'person_id' => $validatedData['person_id'],
            ]);
    
            return redirect()->route('phones.index')->with('success', 'Phone updated successfully');
            } catch (\Exception $e) {
                // Mostrar el error
                dd($e->getMessage());
            }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $phone = Phones::findOrFail($id);
        $phone->delete();

        return redirect()->route('phones.index')->with('success', 'Phone discharged successfully.');
    }

    // Restaurar una persona eliminada
    public function restore($id)
    {
        $phone = Phones::withTrashed()->findOrFail($id);
        $phone->restore();

        return redirect()->route('phones.index')->with('success', 'Phone restored successfully.');
    }
}
