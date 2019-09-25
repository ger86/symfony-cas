<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController {
    public function list(CategoryRepository $categoryRepository): Response {
        $categories = $categoryRepository->findAllWithArticlesCount();
        return $this->render('categories.html.twig', ['categories' => $categories]);
    }

    public function category($id, CategoryRepository $categoryRepository, ArticleRepository $articleRepository): Response {
        $category = $categoryRepository->find($id);
        if (empty($category)) {
            throw $this->createNotFoundException('Category not found');
        }
        $countOfArticles = $articleRepository->countByCategory($category);
        $response = new Response('Hola mundo con '.$category->getName(). ': '.$countOfArticles);
        return $response;
    }

    public function update($id, EntityManagerInterface $em, CategoryRepository $categoryRepository): Response {
        $category = $categoryRepository->find($id);
        if (empty($category)) {
            throw $this->createNotFoundException('Category not found');
        }
        $category->setName('updated name');
        $em->flush();

        $response = new Response('Hola mundo con '.$category->getName());
        return $response;
    }

    public function delete($id, EntityManagerInterface $em, CategoryRepository $categoryRepository): Response {
        $category = $categoryRepository->find($id);
        if (empty($category)) {
            throw $this->createNotFoundException('Category not found');
        }
        $em->remove($category);
        $em->flush();

        $response = new Response('He borrado la categoría con id'. $id);
        return $response;
    }

    public function create(EntityManagerInterface $em): Response {
        $category = new Category();
        $category->setName('name'.random_int(0, PHP_INT_MAX));
        $em->persist($category);
        $em->flush();
        $response = new Response('Hola mundo creador'.$category->getId());
        return $response;
    }
}