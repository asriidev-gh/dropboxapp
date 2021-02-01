<?php
namespace App\Utils;

class ReportParser 
{
    public function convertToArray($csvFile)
    {        
        $fileHandle = fopen(__DIR__."/../downloads/".$csvFile, "r");                
        $itemsArr = array();

        //Loop through the CSV rows.
        while (($row = fgetcsv($fileHandle, 0, ",")) !== FALSE) {            
            if($row[0] != "SKU") array_push($itemsArr,[$row[0],$row[1]]);                            
        }
        
        return $itemsArr;
    }

    public function convertToCsv($dataArr,$csvName)
    {                 
        $path = __DIR__."/../uploads/".$csvName;        
        if(file_exists($csvName)){
            unlink($path);
        }        

        $file = fopen($path,"w");
        if($dataArr){
            foreach ($dataArr as $line) {
                fputcsv($file, $line);
            }
            return true;
        }
        return false;        
    }
}