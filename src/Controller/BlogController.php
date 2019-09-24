<?php

namespace App\Controller;

use App\Entity\Article;
use App\Service\ArticleManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends AbstractController {
    public function list(Request $request): Response {
        $response = new Response('Hola mundo');
        return $response;
    }

    public function article($id, ArticleManager $articleManager): Response {
        $article = $articleManager->find($id);
        if (empty($article)) {
            throw $this->createNotFoundException('Article not found');
        }
        $response = new Response('Hola mundo con '.$article->getTitle());
        return $response;
    }

    public function update($id, ArticleManager $articleManager, EntityManagerInterface $em): Response {
        $article = $articleManager->find($id);
        if (empty($article)) {
            throw $this->createNotFoundException('Article not found');
        }
        $article->setTitle('hey world');
        $em->flush();

        $response = new Response('Hola mundo con '.$article->getTitle());
        return $response;
    }

    public function delete($id, ArticleManager $articleManager, EntityManagerInterface $em): Response {
        $article = $articleManager->find($id);
        if (empty($article)) {
            throw $this->createNotFoundException('Article not found');
        }
        $em->remove($article);
        $em->flush();

        $response = new Response('He borrado el artículo con id'. $id);
        return $response;
    }

    public function create(ArticleManager $articleManager): Response {
        $article = new Article();
        $article->setTitle('title'.random_int(0, PHP_INT_MAX));
        $article->setBody('body');
        $articleManager->save($article);
        $response = new Response('Hola mundo creador'.$article->getId());
        return $response;
    }
}