<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortenedUrl extends Model
{
    use HasFactory;

    protected $fillable = [
        'long_url',
        'short_url',
        'click_count',
        'click_history'
    ];

    protected $casts = [
        'click_history' => 'array'
    ];

    public function addClickToHistory()
    {
        $clickHistory = $this->click_history ?? [];
        $clickHistory[] = [
            'clicked_at' => now()->toDateTimeString()
        ];
        $this->update([
            'click_count' => $this->click_count + 1,
            'click_history' => $clickHistory
        ]);
    }
}
