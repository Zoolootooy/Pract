<?php

namespace App\Http\Controllers;

use App\Models\Search;
use App\Models\SearchingResult;
use Illuminate\Http\Request;
use Google\Client;

class SearchController extends Controller
{
    public function store(Request $request)
    {

        $search = Search::where('query', $request->search)->get();

        if (!isset($search[0]->id)) {
            $client = new \Google_Client();
            $client->setApplicationName(env('APP_NAME'));
            $client->setScopes([
                'https://www.googleapis.com/auth/youtube.force-ssl',
            ]);
            $client->setDeveloperKey(config('youtube.youtube_api'));

            $service = new \Google_Service_YouTube($client);
            $optParams = array(
                'maxResults' => 5,
                'q' => $request->search,
                'type' => 'video'
            );
            $results = $service->search->listSearch('snippet', $optParams);
            $search = Search::create(['query' => $request->search]);

            $searchResults = [];
            foreach ($results as $result) {
                $row = [
                    'search_id' => $search->id,
                    'title' => $result->snippet->title,
                    'link' => 'https://www.youtube.com/watch?v=' . $result->id->videoId,
                    'preview' => $result->snippet->thumbnails->high->url,
                    'channel' => $result->snippet->channelTitle,
                    'channelLink' => 'https://www.youtube.com/channel/' . $result->snippet->channelId
                ];
                array_push($searchResults, collect($row));
                $searchRes = SearchingResult::create($row);

            }


            $searchResults = collect($searchResults);
            return view('results', compact('searchResults'));
        } else {
            $searchResults = SearchingResult::where('search_id', $search[0]->id)->get();
            return view('results', compact('searchResults'));
        }
    }
}
