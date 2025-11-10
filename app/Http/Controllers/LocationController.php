<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lapangan;

class LocationController extends Controller
{
    /**
     * Display the specified lapangan (location).
     */
    public function show($id)
    {
        // Try to find by primary key of legacy table
        $lapangan = Lapangan::find($id);

        if (! $lapangan) {
            abort(404, 'Lokasi lapangan tidak ditemukan');
        }

        return view('locations.show', ['location' => $lapangan]);
    }

    /**
     * Display a listing of locations, optionally filtered by type.
     */
    public function index(Request $request)
    {
        $type = $request->query('type');
        $query = Lapangan::query();
        if ($type) {
            // legacy table stores type in 'jenis_lapangan_232112'; use case-insensitive match
            $typeVal = mb_strtolower($type);
            $query->whereRaw('LOWER(jenis_lapangan_232112) = ?', [$typeVal]);
        }

    // use the model primary key for ordering (legacy table uses a different PK name)
    $pk = (new Lapangan())->getKeyName();
    $locations = $query->orderBy($pk, 'asc')->get();

        return view('locations.index', ['locations' => $locations, 'filter' => $type]);
    }
}
