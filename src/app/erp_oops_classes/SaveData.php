<?php
declare(strict_types=1);
namespace app\erp_oops_classes;

class SaveData
{
    public function saveData(array $lines):void
    {
        echo "Saved " . count($lines) . " lines to database";
    }
}