<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::all();
        return view('patients.index', compact('patients'));
    }

    public function store(Request $request)
    {
        Patient::create($request->all());
        return redirect('/patients')->with('success', 'Pasien berhasil ditambahkan!');
    }

        public function edit($id)
    {
        $patient = Patient::findOrFail($id);
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);
        $patient->update($request->all());
        return redirect('/patients')->with('success', 'Data pasien berhasil diubah!');
    }

    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();
        return redirect('/patients')->with('success', 'Data pasien berhasil dihapus!');
    }
}
