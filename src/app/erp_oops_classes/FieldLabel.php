<?php

namespace app\erp_oops_classes;

#[\Attribute]
class FieldLabel
{
    public function __construct(public string $label){}
}