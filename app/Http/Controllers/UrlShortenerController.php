<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortenedUrl;
use Illuminate\Support\Str;

class UrlShortenerController extends Controller
{
    public function shorten(Request $request)
    {
        $request->validate([
            'long_url' => 'required|url|max:255',
        ]);

        $longUrl = $request->input('long_url');
        $shortUrl = Str::random(6);

        ShortenedUrl::create([
            'long_url' => $longUrl,
            'short_url' => $shortUrl,
            'click_count' => 0,
        ]);

        $res['shortUrl'] = $shortUrl;
        return response($res);
    }

    public function list()
    {
        $urls = ShortenedUrl::orderBy('created_at', 'desc')->get();
        return response(['urls'=> $urls]);
    }

    public function redirectTo($shortUrl)
    {
        $shortenedUrl = ShortenedUrl::where('short_url', $shortUrl)->firstOrFail();
        $shortenedUrl->addClickToHistory();
        return redirect($shortenedUrl->long_url);

    }

    public function stats()
    {
        $mostVisitedUrls = ShortenedUrl::orderBy('click_count', 'desc')->limit(10)->get();
        $allShortened = ShortenedUrl::all();
        return response(['mostVisitedUrls' => $mostVisitedUrls, 'allShortened' => $allShortened]);
    }

    public function getShortUrlStatistics($shortUrl)
    {
        $shortenedUrl = ShortenedUrl::where('short_url', $shortUrl)->firstOrFail();
        $weekClicks = $shortenedUrl->getClickCountForPeriod('week');
        $monthClicks = $shortenedUrl->getClickCountForPeriod('month');
        $yearClicks = $shortenedUrl->getClickCountForPeriod('year');

        $res = [ 
            'weekClicks' => $weekClicks, 
            'monthClicks' => $monthClicks,
            'yearClicks' => $yearClicks
        ];
        return response($res);
    }
}