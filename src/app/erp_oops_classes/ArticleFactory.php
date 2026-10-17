<?php
declare(strict_types=1);
namespace app\erp_oops_classes;

class ArticleFactory
{
    public static function create(string $type, string $name, ?float $price = null): AbstractArticle
    {

        return match ($type) {
            'material' => new Material(AbstractArticle::generateId(), $name, $price ?? throw new \InvalidArgumentException("Material must have a price ")),
            'freeSample'=> new FreeSample(AbstractArticle::generateId(),$name),
            default => throw new \InvalidArgumentException("Invalid Article Type: $type"),
        };
    }
}