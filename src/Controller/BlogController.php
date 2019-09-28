<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\Type\ArticleFormType;
use App\Repository\CategoryRepository;
use App\Service\ArticleManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends AbstractController
{
    public function list(ArticleManager $articleManager): Response
    {
        $articles = $articleManager->findAll();
        return $this->render('blog.html.twig', [
            'articles' => $articles
        ]);
    }

    public function article($id, ArticleManager $articleManager): Response
    {
        $article = $articleManager->find($id);
        if (empty($article)) {
            throw $this->createNotFoundException('Article not found');
        }
        $response = new Response('Hola mundo con ' . $article->getTitle());
        return $response;
    }

    public function update(
        $id,
        ArticleManager $articleManager,
        Request $request
    ): Response {
        $article = $articleManager->find($id);
        if (empty($article)) {
            throw $this->createNotFoundException('Article not found');
        }
        $form = $this->createForm(ArticleFormType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $articleManager->save($article);
            return $this->redirectToRoute('blog_article', ['id' => $article->getId()]);
        }
        return $this->render('create_article.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function delete($id, ArticleManager $articleManager, EntityManagerInterface $em): Response
    {
        $article = $articleManager->find($id);
        if (empty($article)) {
            throw $this->createNotFoundException('Article not found');
        }
        $em->remove($article);
        $em->flush();

        $response = new Response('He borrado el artículo con id' . $id);
        return $response;
    }

    public function create(Request $request, ArticleManager $articleManager): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleFormType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $articleManager->save($article);
            return $this->redirectToRoute('blog_article', ['id' => $article->getId()]);
        }
        return $this->render( 'create_article.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
