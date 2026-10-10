<?php
declare(strict_types=1);
namespace app\erp_oops_classes;

class VatCalculator
{
    public function __invoke(AbstractArticle $article, float $vatRate=0.19):float
    {
        return round($article->getValue() * (1+$vatRate), 2);
    }
}