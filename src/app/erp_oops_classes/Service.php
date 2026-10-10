<?php
declare(strict_types=1);
namespace app\erp_oops_classes;

class Service extends AbstractArticle
{
    public function __construct(
        int $id,
        string $name,
        private float $hourlyRate
    )
    {
        parent::__construct($id, $name);
    }
    public function getDescription():string
    {
        return "{$this->name} :" . "{$this->hourlyRate}" .  ' EUR/unit';
    }
    public function getSummary(): string
    {
        return parent::getSummary();
    }
    public function getValue():float
    {
        return $this->hourlyRate;
    }
}