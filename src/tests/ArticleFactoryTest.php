<?php
declare(strict_types=1);
namespace src\tests;
use PHPUnit\Framework\TestCase;
use app\erp_oops_classes\ArticleFactory;
use app\erp_oops_classes\Material;
use app\erp_oops_classes\FreeSample;

class ArticleFactoryTest extends TestCase
{
    public function testToCreateMaterial(): void
    {
        $material = ArticleFactory::create('material','test',10);
        $this->assertInstanceOf(Material::class, $material);
    }

    public function testToCreateFreeSample(): void
    {
        $freeSample = ArticleFactory::create('freeSample','freeSample-test');
        $this->assertInstanceOf(FreeSample::class, $freeSample);
    }
    public function testToCreateUnknownArticle(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        ArticleFactory::create('UnknownType','test',10);
    }
    public function testToCreateMaterialWithoutPrice(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        ArticleFactory::create('material','test');
    }
}