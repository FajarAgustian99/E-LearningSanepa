<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class QuizSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'class_id',
        'user_id',
        'answers',
        'score',
        'essay_scores',
        'score_correct',
        'score_incorrect',
        'is_submitted',
        'start_time',
        'end_time',
        'submitted_at',
    ];

    protected $casts = [
        'answers'       => 'array',
        'essay_scores'  => 'array',
        'is_submitted'  => 'boolean',
        'start_time'    => 'datetime',
        'end_time'      => 'datetime',
        'submitted_at'  => 'datetime',
    ];

    /* ===========================
       RELATION
    =========================== */

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /* ===========================
       HELPER (UNTUK VIEW & LOGIC)
    =========================== */

    /**
     * Ambil jawaban apapun (PG / Essay)
     */
    public function getAnswer($questionId)
    {
        return $this->answers[$questionId] ?? null;
    }

    /**
     * Cek apakah waktu quiz masih aktif
     */
    public function isTimeActive(): bool
    {
        return now()->lessThanOrEqualTo($this->end_time);
    }

    /**
     * Sisa waktu (detik)
     */
    public function remainingSeconds(): int
    {
        if (!$this->end_time) {
            return 0;
        }

        return max(0, now()->diffInSeconds($this->end_time, false));
    }

    /**
     * Tandai quiz sudah disubmit
     */
    public function markAsSubmitted(): void
    {
        $this->update([
            'is_submitted' => true,
            'submitted_at' => now(),
        ]);
    }
}
