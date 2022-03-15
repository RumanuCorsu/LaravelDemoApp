<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\VideoCollection;
use App\Http\Resources\VideoResource;
use App\Models\Video;

class VideoController extends Controller
{
    public function store(Request $request){
        $limit = !empty($request->limit) && is_numeric($request->limit) ? $request->limit : '15';
        $cur_page = !empty($request->page) && is_numeric($request->page) ? $request->page : '1';
        return new VideoCollection(Video::paginate($limit, ['*'], 'page', $cur_page));
    }

    public function index(Request $request){
        if(isset($request->user_id) && isset($request->name) && isset($request->url)){
            $result = new VideoResource(Video::create($request->all()));
        }else{
            $result = response()->json(['data' => 'error']);
        }
        return $result;
    }

    public function show(Video $video){
        return !empty($video->id) ? new VideoResource($video) : response()->json(['data' => 'not found']);
    }

    public function update(Request $request, Video $video){
        if(isset($request->user_id) || isset($request->name) || isset($request->url)) {
            $video->update($request->all());
        }
        return new VideoResource($video);
    }

    public function delete(Video $video){
        return $video->delete() ? response()->json(['data'=>'ok']) : response()->json(['data'=>'error']);
    }
}
