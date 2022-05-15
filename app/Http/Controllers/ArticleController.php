<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Resources\ArticleResource;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $article = Article::paginate(5);
        return response([
            'articles' => ArticleResource::collection($article),
            'message' => 'Success'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data  = $request->all();

        $validator = Validator::make($data,[
            'title' => 'required|max:value:255',
            'content' => 'required',
            'user_id' => 'required',
            'category_id' => 'required'
        ]);

        if($request->file('image')){
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        if($validator->fails()){
            return response(['error' => $validator->errors(),
            'Validation Error']);
        }

        $article = Article::create($data);

        return response([
            'article' => new ArticleResource($article),
            'message' => 'Success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return response([
            'article' => new ArticleResource($article),
            'message' => 'Success'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $article->update($request->all());
        return response(['article' => new ArticleResource($article),
            'message' => 'Success'], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return response(['message' => 'Article Deleted'], 200);
    }
}
