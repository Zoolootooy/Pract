<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Client;

class SearchController extends Controller
{
    public function store(Request $request)
    {

        $client = new \Google_Client();
        $client->setApplicationName(env('APP_NAME'));
        $client->setScopes([
            'https://www.googleapis.com/auth/youtube.force-ssl',
        ]);
        $client->setDeveloperKey(config('youtube.youtube_api'));

        $service = new \Google_Service_YouTube($client);
        $optParams = array(
            'maxResults' => 25,
            'q' => $request->search,
            'type' => 'video'
        );
        $results = $service->search->listSearch('snippet', $optParams);

        $searchResults = [];
        foreach ($results as $result) {
            $row = [
                'title' => $result->snippet->title,
                'link' => 'https://www.youtube.com/watch?v=' . $result->id->videoId,
                'preview' => $result->snippet->thumbnails->high->url,
                'channel' => $result->snippet->channelTitle,
                'channelLink' => 'https://www.youtube.com/channel/' . $result->snippet->channelId
            ];
            array_push($searchResults, collect($row));
        }
        $searchResults = collect($searchResults);

        return view('results', compact('searchResults'));
    }
}
