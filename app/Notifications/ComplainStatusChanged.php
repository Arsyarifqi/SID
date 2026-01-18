<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ComplainStatusChanged extends Notification
{
    use Queueable;

    protected $complain;
    protected $oldStatus;
    protected $newStatus;

    /**
     * Parameter dikirim dari Controller saat status diupdate
     */
    public function __construct($complain, $oldStatus, $newStatus)
    {
        $this->complain = $complain;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }

    /**
     * Menggunakan channel database
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Struktur data yang disimpan di kolom 'data' pada tabel notifications
     */
    public function toArray($notifiable)
    {
        return [
            'complain_id' => $this->complain->id,
            'title'       => $this->complain->title,
            'old_status'  => $this->oldStatus,
            'new_status'  => $this->newStatus,
            'message'     => 'Status aduan "' . $this->complain->title . '" berubah dari ' . $this->oldStatus . ' menjadi ' . $this->newStatus,
        ];
    }
}