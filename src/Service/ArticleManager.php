<?php

namespace App\Service;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;

class ArticleManager
{ 
    private $articleRepository;
    private $em;

    public function __construct(ArticleRepository $articleRepository, EntityManagerInterface $em)
    {
        $this->articleRepository = $articleRepository;
        $this->em = $em;
    }

    public function findAll(): array {
        return $this->articleRepository->findAll();
    }

    public function find(int $id): ?Article {
        $article = $this->articleRepository->find($id);
        return $article;
    }

    public function save(Article $article): Article {
        $this->em->persist($article);
        $this->em->flush();
        return $article;
    }
}
