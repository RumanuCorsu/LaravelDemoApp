<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentResource;

class CommentController extends Controller
{
    public function store(Request $request){
        $limit = !empty($request->limit) && is_numeric($request->limit) ? $request->limit : '15';
        $cur_page = !empty($request->page) && is_numeric($request->page) ? $request->page : '1';
        return new CommentCollection(Comment::paginate($limit, ['*'], 'page', $cur_page));
    }

    public function index(Request $request){
        if(isset($request->user_id) && isset($request->comment) && ($request->video_id xor $request->article_id)){
            $result = new CommentResource(Comment::create($request->all()));
        }else{
            $result = response()->json(['data' => 'error']);
        }
        return $result;
    }

    public function show(Comment $current_comment){
        return !empty($current_comment->id) ? new CommentResource($current_comment) : response()->json(['data' => 'not found']);
    }

    public function update(Request $request, Comment $current_comment){
        $typeForUnset = is_null($current_comment->video_id) ? 'video_id' : 'article_id';
        $ArrayRequest = $request->all();
        unset($ArrayRequest[$typeForUnset]);
        $current_comment->update($ArrayRequest);
        return new CommentResource($current_comment);
    }

    public function delete(Comment $current_comment){
        return $current_comment->delete() ? response()->json(['data'=>'ok']) : response()->json(['data'=>'error']);
    }
}
