<?php
declare(strict_types=1);
namespace app\erp_oops_classes;

interface Auditable extends Exportable
{
    public function getAuditInfo():string;
}