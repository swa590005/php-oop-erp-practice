<?php
declare(strict_types=1);
namespace app\erp_oops_classes;

class InMemoryArticleRepository implements ArticleRepository
{
    private array $articles=[];
    public function find(int $id):?AbstractArticle
    {
        return $this->articles[$id] ?? null;
    }
    public function add(AbstractArticle $article):void
    {
        $this->articles[]=$article;
    }
}