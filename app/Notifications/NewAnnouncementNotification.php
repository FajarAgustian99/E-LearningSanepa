<?php

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class NewAnnouncementNotification extends Notification
{
    use Queueable;

    public function __construct(public $announcement) {}

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Pengumuman baru: ' . $this->announcement->title,
            'url' => route('student.announcements.show', $this->announcement->id),
        ];
    }

    |--------------------------------------------------------------------------
    | RELASI TUGAS
    |--------------------------------------------------------------------------
    */
    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'teacher_id');
    }
  
    /*
    |--------------------------------------------------------------------------
    | MATERIAL & QUIZ SUBMISSIONS
    |--------------------------------------------------------------------------
    */
    public function materials()
    {
        return $this->belongsToMany(Material::class, 'material_user', 'user_id', 'material_id')
            ->withTimestamps();
    }

    public function quizSubmissions()
    {
        return $this->hasMany(QuizSubmission::class, 'user_id');
    }

    /*
    |--------------------------------------------------------------------------
    | NOTIFIKASI
    |--------------------------------------------------------------------------
    */
    public function notifications()
    {
        return $this->hasMany(Notification::class)->latest();
    }       
}
