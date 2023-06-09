<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

use Log;

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

    public function getClickCountForPeriod($period, $startDate = null)
    {
        $clickHistory = $this->click_history ?? [];
        $clickCount = 0;
        $now = now();

        switch ($period) {
            case 'week':
                $startDate = $startDate ?? date("Y-m-d H:i:s", strtotime("-7 days"));
                $endDate = date("Y-m-d H:i:s");
                break;
            case 'month':
                $startDate = $startDate ?? date("Y-m-d H:i:s", strtotime("-1 month"));
                $endDate = date("Y-m-d H:i:s");
                break;
            case 'year':
                $startDate = $startDate ?? date("Y-m-d H:i:s", strtotime("-1 year"));
                $endDate = date("Y-m-d H:i:s");
                break;
            default:
                throw new InvalidArgumentException('Invalid period');
        }
        foreach ($clickHistory as $click) {
            $clickedAt = Carbon::parse($click['clicked_at']);

            Log::error('$startDate '. $startDate);
            Log::error('$endDate '. $endDate);
            Log::error('$clickedAt '. $clickedAt);

            if ($clickedAt->between($startDate, $endDate)) {
                $clickCount++;
            }
        }
        return $clickCount;
    }
}
