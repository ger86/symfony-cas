<?php

namespace App\Tests\Service;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Service\ArticleManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ArticleManagerTest extends KernelTestCase
{

    public function testFindAll()
    {
        $entityManager = $this->getMockBuilder(EntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $entityManager
            ->expects(self::exactly(0))
            ->method('flush');

        $articleRepository = $this->getMockBuilder(ArticleRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $article1 = new Article();
        $article1->setTitle('title1');
        $article2 = new Article();
        $article2->setTitle('title2');

        $articleRepository
            ->expects(self::exactly(1))
            ->method('findAll')
            ->willReturn([$article1, $article2]);

        $articleManager = new ArticleManager($articleRepository, $entityManager);

        $dev = $articleManager->findAll();
        $this->assertEquals(2, count($dev));
        $this->assertEquals('title1', $dev[0]->getTitle());
    }
}
