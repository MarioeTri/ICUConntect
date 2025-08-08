<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\ConditionHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class PatientController extends Controller
{
    public function landing()
    {
        $patients = Patient::whereNotNull('condition')->orderByDesc('id')->get(['id', 'name']);
        return view('landing', compact('patients'));
    }

    public function nurseDashboard(Request $request)
    {
        $searchQuery = $request->query('search', '');
        $query = Patient::query();
        if ($searchQuery) {
            $query->where('name', 'like', '%' . $searchQuery . '%');
        }
        $patients = $query->orderByDesc('id')->get();
        return view('nurse_dashboard', compact('patients', 'searchQuery'));
    }

    public function addPatient(Request $request)
    {
        $request->validate([
            'patient_name' => 'required|string',
        ]);

        $patient = Patient::create([
            'name' => $request->patient_name,
            'access_key' => Str::random(8),
            'family_member_name' => $request->family_member_name,
            'phone_number' => $request->phone_number,
            'emergency_phone_number' => $request->emergency_phone_number,
            'id_card_number' => $request->id_card_number,
            'address' => $request->address,
            'room_responsible_person' => $request->room_responsible_person,
            'room_responsible_phone' => $request->room_responsible_phone,
            'doctor_name' => $request->doctor_name,
            'doctor_phone' => $request->doctor_phone,
        ]);

        Session::flash('success', "Pasien {$patient->name} ditambahkan dengan key: {$patient->access_key}");
        return redirect()->route('nurse_dashboard');
    }

    public function patientDetail(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);
        $history = ConditionHistory::where('patient_id', $id)->orderByDesc('timestamp')->get(['condition', 'timestamp']);

        if (!Session::has('nurse')) {
            $key = $request->query('key', '');
            if ($key !== $patient->access_key) {
                return redirect()->route('access_patient', $id);
            }
        }

        return view('patient_detail', compact('patient', 'history'));
    }

    public function updateCondition(Request $request, $id)
    {
        $request->validate([
            'condition' => 'required|string',
        ]);

        $patient = Patient::findOrFail($id);
        $patient->update(['condition' => $request->condition]);
        ConditionHistory::create([
            'patient_id' => $id,
            'condition' => $request->condition,
            'timestamp' => now(),
        ]);

        Session::flash('success', 'Kondisi pasien diperbarui!');
        return redirect()->route('patient_detail', $id);
    }

    public function accessPatient($id)
    {
        $patient = Patient::findOrFail($id);
        return view('access_patient', compact('patient'));
    }

    public function verifyAccess(Request $request, $id)
    {
        $request->validate([
            'key' => 'required|string',
        ]);

        $patient = Patient::findOrFail($id);
        if ($request->key === $patient->access_key) {
            return redirect()->route('patient_detail', ['id' => $id, 'key' => $request->key]);
        }

        Session::flash('danger', 'Key akses salah! Hubungi perawat.');
        return redirect()->route('access_patient', $id);
    }
}