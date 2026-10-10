<?php
declare(strict_types=1);
namespace app\erp_oops_classes;

abstract class AbstractArticle
{
    private static int $nextId=1;
    public function __construct(
        protected readonly int $id,
        protected readonly string $name
    )
    {}

    abstract public function getDescription():string;
    abstract public function getValue():float;

    public function getSummary(): string
    {
        return "Article #{$this->id}: {$this->name}";
    }
    public static function generateId():int
    {
        return self::$nextId++;
    }
    public function __toString():string
    {
        return $this->getSummary();
    }
    public static function whoAmI():string
    {
        return self::class;
    }
    public static function whoCalledMe():string
    {
        return static::class;
    }

    public static function createBlank(int $id, string $name,...$extras):static
    {
        return new static($id, $name, ...$extras);
    }
}