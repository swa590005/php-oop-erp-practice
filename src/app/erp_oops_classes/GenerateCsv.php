<?php

namespace app\erp_oops_classes;

class GenerateCsv
{
    private const COLUMNS = ['name','quantity','unitPrice'];
    public function generateCsv(array $lines):string
    {
        $csv = '';
        $csv = implode(';', self::COLUMNS)."\n";
        foreach($lines as $line){
            $cell =[];
            foreach(self::COLUMNS as $column){
                $cell[] = $line[$column];
            }
            $csv .= implode(';', $cell)."\n";
        }
        return $csv;
    }
}