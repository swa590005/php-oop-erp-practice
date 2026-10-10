<?php

namespace app\erp_oops_classes;

class Warehouse
{
    private array $items = [];//will hold StockLedger objects, keyed by item name.

    public function addItem(string $name, StockLedger $ledger):void //that stores the ledger into $items under that name.
    {
        $this->items[$name] = $ledger;
    }

    public function getItem(string $name): StockLedger //that returns the StockLedger stored under that name.
    {
        return $this->items[$name];
    }
}


