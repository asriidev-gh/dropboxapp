<?php
namespace App\Report;

class ReportTwo extends ReportOne{
    public function generate($allProductsStock,$allProductsVendor)
    {
        $reportItemsArr = array();
        array_walk($allProductsVendor,function($val,$key) use($allProductsStock,&$reportItemsArr){    
            foreach ($allProductsStock as $allProductsStockVal) {                
                if($val[0] == $allProductsStockVal[0] && $allProductsStockVal[1] > 0){
                    array_push($reportItemsArr,array($val[0],$allProductsStockVal[1],$val[1]));
                }
            }
        });

        # Sort data from SKU'S
        usort($reportItemsArr, function($a, $b) {                             
            return $a[0] <=> $b[0];
        });
        
        return array_merge(array(["SKU","stock_quantity","vendor"]),$reportItemsArr);
    }
}