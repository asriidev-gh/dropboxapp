<?php 
namespace App\Report;

Interface ReportInterface {
    public function generate($allProductsStock,$allProductsVendor);
}