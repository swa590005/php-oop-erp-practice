<?php
declare(strict_types=1);
namespace src\tests;
use app\erp_oops_classes\ArticleFactory;
use app\erp_oops_classes\InMemoryArticleRepository;
use PHPUnit\Framework\TestCase;

class InMemoryArticleRepositoryTest extends TestCase
{
    private InMemoryArticleRepository $repository;
    protected function setUp(): void
    {
        $this->repository = new InMemoryArticleRepository();
    }
    public function testAddArticles(): void
    {
        $material = ArticleFactory::create('material','test',10);
        $this->repository->add($material);
        $this->assertSame($material, $this->repository->find($material->getArticleId()));
    }

    public function testFindNonExistingArticle(): void
    {
        $material = ArticleFactory::create('material','test',10);
        $this->repository->add($material);
        $this->assertNull($this->repository->find($material->getArticleId()+999999));
    }

    public function testAddTwoArticles():void
    {
        $material1 = ArticleFactory::create('material','test1',10);
        $material2 = ArticleFactory::create('material','test2',20);
        $this->repository->add($material1);
        $this->repository->add($material2);
        $this->assertSame($material1, $this->repository->find($material1->getArticleId()));
        $this->assertSame($material2, $this->repository->find($material2->getArticleId()));
    }
}