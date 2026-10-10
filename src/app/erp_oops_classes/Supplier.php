<?php
declare(strict_types=1);
namespace app\erp_oops_classes;

class Supplier implements Exportable
{
    private string $companyName;
    private string $contactEmail;
     use Identifiable, Loggable {
         Identifiable::identify insteadof Loggable;
         Loggable::identify as identifyLoggable;
     }

    public function __construct(string $companyName, string $contactEmail, int $id,string $name)
    {
        $this->companyName = $companyName;
        $this->contactEmail = $contactEmail;
        $this->id = $id;
        $this->name = $name;
    }
    public function toCsvRow():string
    {
        return "{$this->companyName},{$this->contactEmail}";
    }
}