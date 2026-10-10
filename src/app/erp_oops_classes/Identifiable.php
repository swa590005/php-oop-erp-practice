<?php
declare(strict_types=1);
namespace app\erp_oops_classes;

trait Identifiable
{
    private int $id;
    private string $name;
    public function __construct(int $id, string $name){
        $this->id = $id;
        $this->name = $name;
    }
    public function identify():string
    {
        return "#{$this->id}: {$this->name}";
    }
}