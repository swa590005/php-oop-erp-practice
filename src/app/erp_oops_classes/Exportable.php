<?php
declare(strict_types=1);
namespace app\erp_oops_classes;

interface Exportable
{
    public function toCsvRow():string;
}