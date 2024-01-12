<?php

namespace App\Http\Controllers;

use App\Http\Requests\Article\IndexRequest;
use App\Http\Resources\ArticleCollection;
use App\Models\Article;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request)
    {
        $data = Article::search($request->search, $request->filter)->paginate();
        return new ArticleCollection($data);
        // 'author',
        // 'category',
        // 'source',
    }
}
