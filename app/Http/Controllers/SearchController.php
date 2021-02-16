<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Search;
use App\Models\Video;
use Illuminate\Http\Request;
use Google\Client;

class SearchController extends Controller
{

    /**
     * Show search list
     */
    public function index($query)
    {
        $search = Search::where('query', $query)->with(['videos.channel'])->first();
        $videos = $search->videos()->paginate(20);
        return view('results', compact(['videos', 'search']));
    }

    /**
     * Show favorites video list
     */
    public function favorites()
    {
        $videos = Video::where('favorite', 1)->with(['channel'])->paginate(20);
        $search = 'Любимые';
        return  view('results', compact(['videos', 'search']));
    }

    /**
     * Get answer on query and store in DB
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(Request $request)
    {

        $search = Search::where('query', $request->search)->first();

        if (!isset($search->id)) {
            dd('Поиск запрещён');
            $client = new \Google_Client();
            $client->setApplicationName(env('APP_NAME'));
            $client->setScopes([
                'https://www.googleapis.com/auth/youtube.force-ssl',
            ]);
            $client->setDeveloperKey(config('youtube.youtube_api'));

            $service = new \Google_Service_YouTube($client);
            $optParams = array(
                'maxResults' => 50,
                'q' => $request->search,
                'type' => 'video'
            );
            $results = $service->search->listSearch('snippet', $optParams);
            $search = Search::create(['query' => $request->search]);

            $videos = [];
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
                $videosRes = $search->videos()->create($resultRow);
                array_push($videos, collect($resultRow));
//                $searchRes = SearchingResult::create($resultRow);
//                $searchRes = SearchingResult::find($searchRes->id);

//                $channel = $searchRes->channel()->create($channelRow);
//                $channel = Channel::create($channelRow);
//                dump($channel);
//                dump($searchRes);

            }
//            $searchResults = SearchingResult::;
        }

//        TODO сделать отдельный метод index для получения страниц выдачи
        return redirect()->route('search.index', ['query' => $request->search]);
    }

    /**
     * Update row
     * @param Request $request
     * @return false|string
     */
    public function update(Request $request)
    {
        $video = Video::find($request->id)->update(['favorite' => $request->like]);
        return json_encode($video);
    }
}
