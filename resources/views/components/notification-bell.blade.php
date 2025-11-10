<div class="notification-container">
    <div class="notification-bell" onclick="toggleNotifications()">
        🔔
        @php
            $unreadCount = 0;
            if(Session::has('notifications') && isset($user)) {
                $userNotifications = array_filter(Session::get('notifications'), function($notif) use ($user) {
                    return $notif['user_id_232112'] == $user['email'];
                });
                $unreadCount = count($userNotifications);
            }
        @endphp
        @if($unreadCount > 0)
        <span class="notification-badge">{{ $unreadCount }}</span>
        @endif
    </div>
    
    <div class="notification-dropdown" id="notificationDropdown">
        <div class="notification-header">
            <h4>Notifikasi</h4>
            @if($unreadCount > 0)
            <form method="POST" action="{{ route('notifications.clear') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn-clear">Bersihkan</button>
            </form>
            @endif
        </div>
        
        <div class="notification-list">
            @if($unreadCount > 0)
                @foreach(array_slice(array_reverse($userNotifications), 0, 5) as $notification)
                <div class="notification-item {{ $notification['status_232112'] }}">
                    <div class="notification-icon">
                        @if($notification['tipe_232112'] == 'email') 📧
                        @elseif($notification['tipe_232112'] == 'whatsapp') 📱
                        @endif
                    </div>
                    <div class="notification-content">
                        <div class="notification-title">{{ $notification['judul_232112'] }}</div>
                        <div class="notification-message">{{ $notification['pesan_232112'] }}</div>
                        <div class="notification-meta">
                            <span class="notification-type">{{ $notification['tipe_232112'] }}</span>
                            <span class="notification-status {{ $notification['status_232112'] }}">
                                {{ $notification['status_232112'] }}
                            </span>
                            <span class="notification-time">
                                {{ date('H:i', strtotime($notification['created_at_232112'])) }}
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="notification-empty">
                    Tidak ada notifikasi
                </div>
            @endif
        </div>
        
        @if($unreadCount > 0)
        <div class="notification-footer">
            <small>{{ $unreadCount }} notifikasi</small>
        </div>
        @endif
    </div>
</div>

<style>
.notification-container {
    position: relative;
    display: inline-block;
}

.notification-bell {
    position: relative;
    cursor: pointer;
    padding: 10px 12px;
    border-radius: 8px;
    transition: all 0.3s;
    font-size: 1.3rem;
    background: rgba(255, 255, 255, 0.15);
    border: none;
}

.notification-bell:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: scale(1.05);
}

.notification-badge {
    position: absolute;
    top: 5px;
    right: 5px;
    background: #ef4444;
    color: white;
    border-radius: 50%;
    width: 18px;
    height: 18px;
    font-size: 0.7rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    border: 2px solid;
}

.notification-dropdown {
    display: none;
    position: fixed; 
    top: 70px; 
    right: 20px; 
    width: 380px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.3);
    z-index: 99999; 
    border: 1px solid #e2e8f0;
}

.notification-header {
    padding: 1.2rem;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #f8fafc;
    border-radius: 12px 12px 0 0;
}

.notification-header h4 {
    margin: 0;
    color: #2d3748;
    font-size: 1.1rem;
    font-weight: 700;
}

.btn-clear {
    background: #667eea;
    color: white;
    border: none;
    padding: 6px 12px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 0.8rem;
    transition: background 0.3s;
}

.btn-clear:hover {
    background: #5a6fd8;
}

.notification-list {
    max-height: 400px;
    overflow-y: auto;
}

.notification-item {
    padding: 1.2rem;
    border-bottom: 1px solid #f1f5f9;
    transition: background 0.2s;
}

.notification-item:last-child {
    border-bottom: none;
}

.notification-item:hover {
    background: #f8fafc;
}

.notification-item.sent {
    border-left: 4px solid #10b981;
}

.notification-item.failed {
    border-left: 4px solid #ef4444;
}

.notification-item.pending {
    border-left: 4px solid #f59e0b;
}

.notification-item {
    display: flex;
    gap: 1rem;
    align-items: flex-start;
}

.notification-icon {
    font-size: 1.4rem;
    flex-shrink: 0;
    margin-top: 2px;
}

.notification-content {
    flex: 1;
    min-width: 0;
}

.notification-title {
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 0.4rem;
    font-size: 0.95rem;
    line-height: 1.3;
}

.notification-message {
    color: #64748b;
    font-size: 0.85rem;
    margin-bottom: 0.8rem;
    line-height: 1.4;
}

.notification-meta {
    display: flex;
    gap: 0.8rem;
    font-size: 0.75rem;
    align-items: center;
    flex-wrap: wrap;
}

.notification-type {
    color: #667eea;
    text-transform: uppercase;
    font-weight: 700;
    font-size: 0.7rem;
    background: #f0f4ff;
    padding: 0.2rem 0.5rem;
    border-radius: 4px;
}

.notification-status {
    padding: 0.3rem 0.6rem;
    border-radius: 8px;
    font-weight: 700;
    font-size: 0.7rem;
}

.notification-status.sent {
    background: #d1fae5;
    color: #065f46;
}

.notification-status.failed {
    background: #fee2e2;
    color: #991b1b;
}

.notification-status.pending {
    background: #fef3c7;
    color: #92400e;
}

.notification-time {
    color: #94a3b8;
    margin-left: auto;
    font-size: 0.7rem;
}

.notification-empty {
    padding: 3rem 2rem;
    text-align: center;
    color: #94a3b8;
    font-style: italic;
}

.notification-footer {
    padding: 1rem;
    border-top: 1px solid #e2e8f0;
    text-align: center;
    background: #f8fafc;
    border-radius: 0 0 12px 12px;
}

.notification-footer small {
    color: #64748b;
    font-weight: 600;
}

.show {
    display: block !important;
    animation: fadeIn 0.2s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Responsive */
@media (max-width: 768px) {
    .notification-dropdown {
        width: 90vw;
        right: 5vw;
        left: 5vw;
        top: 80px;
    }
}

@media (max-width: 480px) {
    .notification-dropdown {
        width: 95vw;
        right: 2.5vw;
        left: 2.5vw;
    }
    
    .notification-item {
        padding: 1rem;
    }
    
    .notification-meta {
        gap: 0.5rem;
    }
}
</style>

<script>
function toggleNotifications() {
    const dropdown = document.getElementById('notificationDropdown');
    dropdown.classList.toggle('show');
}

document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('notificationDropdown');
    const bell = document.querySelector('.notification-bell');
    
    if (!bell.contains(event.target) && !dropdown.contains(event.target)) {
        dropdown.classList.remove('show');
    }
});

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const dropdown = document.getElementById('notificationDropdown');
        dropdown.classList.remove('show');
    }
});
</script>