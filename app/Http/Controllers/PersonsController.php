<?php

namespace App\Http\Controllers;
use App\Models\Persons;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PersonsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $showDischarges = $request->input('discharges') == 'true';

        if ($showDischarges) {
            // Mostrar las Persons que han sido eliminadas (soft deleted)
            $persons = Persons::onlyTrashed()->get();
        } else {
            // Mostrar personas activas (que no están eliminadas)
            $persons = Persons::all(); // Por defecto excluye los eliminados
        }
        
        return view('persons.index', compact('persons', 'showDischarges'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('persons.entry'); // Asegúrate de que esta ruta coincide con el nombre de la vista
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        try {
        // Validar los datos entrantes
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'dni' => 'required|string|max:11',
            'birth_date' => 'required|date',
            //'entry_date' => 'required|date',
        ]);

        //dd($validatedData); // Muestra los datos enviados

        // Crear un nuevo usuario (o persona) en la base de datos
        Persons::create([
            'full_name' => $validatedData['full_name'],
            'dni' => $validatedData['dni'],
            'birth_date' => $validatedData['birth_date'],
            //'entry_date' => $validatedData['entry_date'],
        ]);

        // Redirigir a alguna ruta (como la lista de usuarios)
        return redirect()->route('persons.index')->with('success', 'Person created successfully');
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
        $person = Persons::findOrFail($id);
        return view('persons.modify', compact('person'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'full_name' => 'required|string|max:255',
                'dni' => 'required|string|max:11',
                'birth_date' => 'required|date',
            ]);
    
            $person = Persons::findOrFail($id);
            $person->update($request->all());
    
            return redirect()->route('persons.index')->with('success', 'Persona actualizada exitosamente');
            } catch (\Exception $e) {
                // Mostrar el error
                dd($e->getMessage());
            }
    }

    /**
     * Remove the specified resource from storage.
     */
    // Soft delete
    public function destroy($id)
    {
        $person = Persons::findOrFail($id);
        $person->delete();

        return redirect()->route('persons.index')->with('success', 'Person discharged successfully.');
    }

    // Restaurar una persona eliminada
    public function restore($id)
    {
        $person = Persons::withTrashed()->findOrFail($id);
        $person->restore();

        return redirect()->route('persons.index')->with('success', 'Person restored successfully.');
    }
}
