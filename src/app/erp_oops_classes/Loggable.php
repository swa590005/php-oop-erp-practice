<?php
declare(strict_types=1);
namespace app\erp_oops_classes;

trait Loggable
{
    private string $name;
    public function identify():string
    {
        return "#[LOG]: {$this->name}";
    }
}