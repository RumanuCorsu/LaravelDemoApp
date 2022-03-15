<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function store(Request $request){
        $limit = !empty($request->limit) && is_numeric($request->limit) ? $request->limit : '15';
        $cur_page = !empty($request->page) && is_numeric($request->page) ? $request->page : '1';
        return new ArticleCollection(Article::paginate($limit, ['*'], 'page', $cur_page));
    }

    public function index(Request $request){
        if(isset($request->user_id) && isset($request->name) && isset($request->article)){
            $result = new ArticleResource(Article::create($request->all()));
        }else{
            $result = response()->json(['data' => 'error']);
        }
        return $result;
    }

    public function show(Article $article){
        return !empty($article->id) ? new ArticleResource($article) : response()->json(['data' => 'not found']);
    }

    public function update(Request $request, Article $article){
        if(isset($request->user_id) || isset($request->name) || isset($request->article)) {
            $article->update($request->all());
        }
        return new ArticleResource($article);
    }

    public function delete(Article $article){
        return $article->delete() ? response()->json(['data'=>'ok']) : response()->json(['data'=>'error']);
    }
}
