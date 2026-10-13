<?php
declare(strict_types=1);
namespace app\erp_oops_classes;

class FreeSample extends AbstractArticle
{
    private ?float $value=null;
    public function __construct(int $id, string $name){
        parent::__construct($id, $name);
    }

    public function getValue():float
    {
       return $this->value ??= 0;
    }
    public function getDescription():string
    {
        return "Free Sample";
    }
}