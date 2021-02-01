<?php
namespace App\Report;

class ReportThree extends ReportOne{
    public function generate($allProductsStock,$allProductsVendor)
    {
        $reportItemsArr = array(["SKU","stock_quantity","vendor"]);
        array_walk($allProductsVendor,function($val,$key) use($allProductsStock,&$reportItemsArr){    
            foreach ($allProductsStock as $allProductsStockVal) {                
                if($val[0] == $allProductsStockVal[0] && $allProductsStockVal[1] < 1){
                    array_push($reportItemsArr,array($val[0],$allProductsStockVal[1],$val[1]));
                }
            }
        });

        return $reportItemsArr;
    }
}