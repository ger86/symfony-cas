<?php

namespace App\EventListener;

use App\Entity\Article;
use App\Service\Slugify;

class ArticleSlugEventListener
{
    private $slugify;

    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }

    public function prePersist(Article $article)
    {
        $this->slugifyArticle($article);
    }

    public function preUpdate(Article $args)
    {
        $this->slugifyArticle($args);
    }

    private function slugifyArticle($article)
    {
        $article->setSlug($this->slugify->slugify($article->getTitle()));
    }
}
