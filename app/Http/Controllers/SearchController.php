<?php

namespace App\Http\Controllers;

use App\Models\Channel;
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
                $channelRow = [
                    'name' => $result->snippet->channelTitle,
                    'link' => 'https://www.youtube.com/channel/' . $result->snippet->channelId
                ];
                if (!Channel::where('name', $channelRow['name'])->first()) {
                    $channel = Channel::create($channelRow);
                }
                $resultRow = [
                    'title' => $result->snippet->title,
                    'link' => 'https://www.youtube.com/watch?v=' . $result->id->videoId,
                    'preview' => $result->snippet->thumbnails->high->url,
                    'channel_id' => $channel->id
                ];
                $searchRes = $search->searchingResult()->create($resultRow);
                array_push($searchResults, collect($resultRow));
//                $searchRes = SearchingResult::create($resultRow);
//                $searchRes = SearchingResult::find($searchRes->id);

//                $channel = $searchRes->channel()->create($channelRow);
//                $channel = Channel::create($channelRow);
//                dump($channel);
//                dump($searchRes);

            }
            dd();
//            $searchResults = SearchingResult::;
            return view('results', compact('searchResults'));
        } else {
            $search = Search::with(['searchingResult.channel'])->first();
            return view('results', compact('search'));
        }
    }
}
