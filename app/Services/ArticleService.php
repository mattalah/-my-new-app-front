<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class ArticleService
{

    public function getArticles(string $category): Collection
    {
        $response = Http::get('https://newsapi.org/v2/top-headlines?category=' . $category . '&apiKey=' . config('newsApi.news_key'));
        return collect($response->json()['articles']);
    }

    public function changeArticleFormat(Collection $articles, string $category): Collection
    {
        return $articles->map(function ($article) use ($category) {
            return [
                'publishedAt' => $article['publishedAt'],
                'category' => $category,
                'source' => $article['source']['name'],
                'author' => $article['author'],
                'title' => $article['title'],
                'description' => $article['description'],
                'urlToImage' => $article['urlToImage'],
                'title' => $article['title'],
                'url' => $article['url']
            ];
        });
    }

    public function store($articles)
    {
        Article::insert($articles->toArray());
    }
}
