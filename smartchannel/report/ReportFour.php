<?php
namespace App\Report;

class ReportFour extends ReportOne{
    public function generate($allProductsStock,$allProductsVendor)
    {
        $reportItemsArr = array();
        array_walk($allProductsVendor,function($val,$key) use($allProductsStock,&$reportItemsArr){    
            foreach ($allProductsStock as $allProductsStockVal) {
                if($val[0] == $allProductsStockVal[0]){
                    array_push($reportItemsArr,array($val[0],$allProductsStockVal[1],$val[1]));
                }
            }
        });
        
        return $this->mapReportOneToNewReportFormat($reportItemsArr);                
    }

    private function mapReportOneToNewReportFormat($reportItemsArr)
    {
        # Format report one to Vendor & Total Stocks
        $newFormatArr = array();                
        foreach ($reportItemsArr as $key => $value) {           
            array_push($newFormatArr,array($value[2]=>$value[1]));           
        }
        
        # Sum items with the same vendor
        $filteredArr = array();                    
        array_walk($newFormatArr, function ($val,$key) use ($newFormatArr,&$filteredArr) {            
            $totalStocks = array_sum(array_column($newFormatArr,array_keys($val)[0]));            
            array_push($filteredArr,[array_keys($val)[0]=>$totalStocks]);
        });

        # Sort data from keys
        usort($filteredArr, function($a, $b) {                       
            return array_keys($a)[0] <=> array_keys($b)[0];
        });
        
        # Get Unique Items        
        $serialized = array_map('serialize', $filteredArr);
        $unique = array_unique($serialized);
        $uniqueItems = array_intersect_key($filteredArr, $unique);

        # Fixed Array Keys
        $finalResult = array();
        array_walk($uniqueItems,function($val) use (&$finalResult){            
            array_push($finalResult,array(array_keys($val)[0],array_values($val)[0]));            
        });        
        return array_merge(array(["Vendor","stock_quantity"]),$finalResult);
    }
}