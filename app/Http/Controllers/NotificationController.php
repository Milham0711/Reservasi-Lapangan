<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class NotificationController extends Controller
{
    public function sendNotification($userId, $judul, $pesan, $tipe = 'email')
    {
        $notifications = Session::get('notifications', []);
        
        $notification = [
            'notifikasl_id_232112' => count($notifications) + 1,
            'user_id_232112' => $userId,
            'judul_232112' => $judul,
            'pesan_232112' => $pesan,
            'tipe_232112' => $tipe,
            'status_232112' => 'pending',
            'created_at_232112' => now()->toDateTimeString()
        ];
        
        $success = $this->simulateSend($tipe, $judul, $pesan);
        
        if ($success) {
            $notification['status_232112'] = 'sent';
        } else {
            $notification['status_232112'] = 'failed';
        }
        
        $notifications[] = $notification;
        Session::put('notifications', $notifications);
        
        return $success;
    }
    
    private function simulateSend($tipe, $judul, $pesan)
    {
        return rand(0, 100) > 20;
    }
    
    public function getUserNotifications($userId)
    {
        $allNotifications = Session::get('notifications', []);
        
        return array_filter($allNotifications, function($notif) use ($userId) {
            return $notif['user_id_232112'] == $userId;
        });
    }
    
    public function getAllNotifications()
    {
        return Session::get('notifications', []);
    }
    
    public function clearNotifications()
    {
        Session::forget('notifications');
        return back()->with('success', 'Notifikasi berhasil dibersihkan');
    }
}