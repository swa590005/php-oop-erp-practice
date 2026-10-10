<?php
declare(strict_types=1);
namespace app\erp_oops_classes;

class Material extends AbstractArticle implements  Auditable
{
    public function __construct(
        int $id,
        string $name,
        private float $unitPrice
    )
    {
        parent::__construct($id, $name);
    }
    public function getDescription():string
    {
        return "{$this->name} :" . "{$this->unitPrice}" .  ' EUR/unit';
    }

    public function getSummary(): string
    {
        return parent::getSummary()."- {$this->unitPrice} EUR/unit";
    }

    public function toCsvRow(): string
    {
        return "{$this->id},{$this->name},{$this->unitPrice}";
    }
    public function getAuditInfo(): string
    {
        return "{$this->id},({$this->name}),- Last known price:{$this->unitPrice}";
    }

    public static function fromCsvRow(string $row):self
    {
        [$id, $name, $unitPrice] = explode(',', $row);
        return new self((int)$id, $name, (float)$unitPrice);
    }
    public function getValue():float
    {
        return $this->unitPrice;
    }
}