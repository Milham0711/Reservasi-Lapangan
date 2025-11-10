<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ReservationController extends Controller
{
    private $reservations = [
        [
            'id' => '1',
            'user_email' => 'user@sportvenue.com',
            'user_name' => 'Rahmat',
            'field_id' => 'futsal_vinyl',
            'field_name' => 'Lapangan Vinyl Futsal',
            'sport_type' => 'futsal',
            'date' => '2024-10-25',
            'start_time' => '19:00',
            'duration' => 2,
            'total_price' => 100000,  
            'status' => 'confirmed',
            'created_at' => '2024-10-20 10:00:00'
        ],
        [
            'id' => '2', 
            'user_email' => 'user2@example.com',
            'user_name' => 'Adhi',
            'field_id' => 'badminton_2',
            'field_name' => 'Badminton 2',
            'sport_type' => 'badminton',
            'date' => '2024-10-26',
            'start_time' => '16:00',
            'duration' => 1,
            'total_price' => 80000,  
            'status' => 'pending',
            'created_at' => '2024-10-21 14:30:00'
        ],
        [
            'id' => '3',
            'user_email' => 'user3@example.com',
            'user_name' => 'Sharga',
            'field_id' => 'futsal_sintetis',
            'field_name' => 'Lapangan Sintetis Futsal',
            'sport_type' => 'futsal',
            'date' => '2024-10-27',
            'start_time' => '20:00',
            'duration' => 3,
            'total_price' => 120000,  
            'status' => 'confirmed',
            'created_at' => '2024-10-22 09:15:00'
        ]
    ];

    public function index()
    {
        if (!Session::has('user')) {
            return redirect()->route('login');
        }

        $user = Session::get('user');
        
        $userReservations = array_filter($this->reservations, function($reservation) use ($user) {
            return $reservation['user_email'] === $user['email'];
        });

        return view('reservations.index', [
            'user' => $user,
            'reservations' => array_values($userReservations)
        ]);
    }

    public function create()
    {
        if (!Session::has('user')) {
            return redirect()->route('login');
        }

        return view('reservations.create', [
            'user' => Session::get('user')
        ]);
    }

    public function store(Request $request)
    {
        if (!Session::has('user')) {
            return redirect()->route('login');
        }

        return back()->with('info', 'Fitur reservasi sedang dalam pengembangan. Simpan sementara dinon-aktifkan.');
    }

    public function allReservations()
    {
        if (!Session::has('user') || Session::get('user')['role'] !== 'admin') {
            return redirect()->route('login');
        }

        return view('reservations.admin-index', [
            'user' => Session::get('user'),
            'reservations' => $this->reservations 
        ]);
    }

    public function edit($id)
    {
        return back()->with('info', 'Fitur edit reservasi sedang dalam pengembangan.');
    }

    public function update(Request $request, $id)
    {
        return back()->with('info', 'Fitur update reservasi sedang dalam pengembangan.');
    }

    public function destroy($id)
    {
        return back()->with('info', 'Fitur hapus reservasi sedang dalam pengembangan.');
    }
}