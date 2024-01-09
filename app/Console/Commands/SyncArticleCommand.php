<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use jcobhams\NewsApi\NewsApi;
use App\Services\ArticleService;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\NewsController;

class SyncArticleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-article-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * article categories.
     *
     * @var array
     */
    protected $categories = ["business", "entertainment", "general", "health", "science", "sports", "technology"];


    public function __construct(private ArticleService $ArticleService, private NewsController $NewsController)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $progressbar = $this->output->createProgressBar(count($this->categories));
        $progressbar->start();
        collect($this->categories)->map(function (string $category, int $key) use ($progressbar) {
            $this->ArticleService->store($this->ArticleService->changeArticleFormat($this->ArticleService->getArticles($category), $category));
            $progressbar->advance();
            return null;
        });
        $progressbar->finish();

        return 0;
    }
}
