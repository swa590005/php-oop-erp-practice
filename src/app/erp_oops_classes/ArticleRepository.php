<?php
declare(strict_types=1);
namespace app\erp_oops_classes;

interface ArticleRepository
{

    public function find(int $id):?AbstractArticle;
    public function add(AbstractArticle $article):void;
}