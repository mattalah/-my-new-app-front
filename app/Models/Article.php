<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'publishedAt',
        'category',
        'source',
        'author',
        'title',
        'description',
        'url',
        'urlToImage'
    ];

    protected $filters = [
        'publishedAt',
        'category',
        'source',
        'author',
    ];

    public function scopeSearch($query, string $search = null, array $params = null)
    {
        if (is_null($params) && isset($search)) {
            $query->generalSearch($search);
        }
        // collect($this->filters)->map(function (string $filter) use ($params, $query, $search) {
        //     if (collect($params)->contains($filter)) {
        //         $query->where($filter, $search);
        //     }
        // });
        return $query;
    }

    public function scopeGeneralSearch($query, string $search)
    {
        $query->orCategory($search)
            ->orSource($search)
            ->orTitle($search)
            ->orDescription($search)
            ->orPublishedAt($search);
    }

    public function scopeTitle($query, string $title): void
    {
        $query->where('title', $title);
    }

    public function scopeOrTitle($query, string $title): void
    {
        $query->orWhere('title', $title);
    }

    public function scopeDescription($query, string $description): void
    {
        $query->where('description', $description);
    }
    public function scopeOrDescription($query, string $description): void
    {
        $query->orWhere('description', $description);
    }

    public function scopeCategory($query, string $category = null): void
    {
        if (isset($category)) {
            $query->where('category', $category);
        }
    }

    public function scopeOrCategory($query, string $category): void
    {
        $query->orWhere('category', $category);
    }

    public function scopeSource($query, string $source): void
    {
        $query->where('source', $source);
    }

    public function scopeOrSource($query, string $source): void
    {
        $query->orWhere('source', $source);
    }

    public function scopePublishedAt($query, string $publishedAt): void
    {
        $query->where('publishedAt', $publishedAt);
    }

    public function scopeOrPublishedAt($query, string $publishedAt): void
    {
        $query->orWhere('publishedAt', $publishedAt);
    }

    public function scopeAuthor($query, string $author = null): void
    {
        if (isset($author)) {
            $query->where('author', $author);
        }
    }
}
