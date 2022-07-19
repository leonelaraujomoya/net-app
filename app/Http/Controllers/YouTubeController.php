<?php 
 
namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class YouTubeController extends Controller
{
    public function searchvideos(Request $request) {
        $videoLists = $this->_videoLists($request->search_query, $request->page_token, $request->order, $request->video_definition, $request->video_duration);
        return response()->json($videoLists);
    }

    public function watchvideo(Request $request) {
        $singleVideo = $this->_singleVideo($request->id);
        $videoLists = $this->_videoLists($request->search_query);
        $resultado = array("singleVideo" => $singleVideo, "videoLists" => $videoLists);
        return response()->json($resultado);
    }

    protected function _videoLists($keywords, $pagetoken, $order, $videodefinition, $videoduration) {
        $part = 'snippet';
        $country = 'VE';
        $apiKey = $this->_apiKey();
        $maxResults = 12;
        $youTubeEndPoint = "https://www.googleapis.com/youtube/v3/search";
        $type = 'video'; // (video, playlist, channel) You can select any one or all, we are getting only videos

        if(strlen(trim($pagetoken)) > 0){
            $url = "$youTubeEndPoint?part=$part&maxResults=$maxResults&regionCode=$country&type=$type&key=$apiKey&q=$keywords&pageToken=$pagetoken";
        }else {
            $url = "$youTubeEndPoint?part=$part&maxResults=$maxResults&regionCode=$country&type=$type&key=$apiKey&q=$keywords";
        }
        if(strlen(trim($order)) > 0){
            $url = $url . "&order=$order";
        }
        if(strlen(trim($videodefinition)) > 0){
            $url = $url . "&videoDefinition=$videodefinition";
        }
        if(strlen(trim($videoduration)) > 0){
            $url = $url . "&videoDuration=$videoduration";
        }
        $response = Http::get($url);
        $results = json_decode($response);
        File::put(storage_path() . '/app/public/results.json', $response->body());
        return $results;
    }

    protected function _singleVideo($id) {
        $apiKey = $this->_apiKey();
        $part = 'snippet, contentDetails, player, statistics';

        //$part = 'id, snippet, contentDetails, fileDetails, player, processingDetails, recordingDetails, statistics, status, suggestions, topicDetails';

        //$part2 = 'contentDetails';

        $url = "https://www.googleapis.com/youtube/v3/videos?part=$part&id=$id&key=$apiKey";
        $response = Http::get($url);
        $results = json_decode($response);
        File::put(storage_path() . '/app/public/single.json', $response->body());
        return $results;
    }

    protected function _apiKey(){
        return "AIzaSyDZREqQS6l581xQE32u1t9iZvlW7YuEHio";
    }
}