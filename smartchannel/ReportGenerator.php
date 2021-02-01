<?php

use App\Utils\MyDropboxApp;
use App\Utils\ReportParser;
use App\Report\ReportOne;
use App\Report\ReportTwo;
use App\Report\ReportThree;
use App\Report\ReportFour;

class ReportGenerator {
    const APP_KEY = "8wjr09c7hid4s74";
    const APP_SECRET = "9sjvptsl30l2mli";
    const ACCESS_TOKEN = "C_AJzxlk9QoAAAAAAAAAAcHjPBjR9vVKmG39YYD5I8H15TKamQeN3hEllGG43_iM";
    private $myDropboxApp;

    public function __construct()
    {            
        $this->myDropboxApp = new MyDropboxApp(self::APP_KEY,self::APP_SECRET,self::ACCESS_TOKEN);        
    }

    public function execute(){
        $this->downloadReports();
        $this->generateReports();
    }

    private function downloadReports(){
        if($this->myDropboxApp->connect()){
            #Download Report Files
            $filesToDownloadArr = array(
                                    array("path"=>"/Devtest/Stocks/all-products-stock.csv","filename"=>"all-products-stock.csv"),
                                    array("path"=>"/Devtest/Vendor/all-products-vendor.csv","filename"=>"all-products-vendor.csv")
                                );
            foreach ($filesToDownloadArr as $key => $value) 
            {        
                if(file_exists($value['path'])){
                    unlink($value['path']);
                }        
                $this->myDropboxApp->downloadFile($value['path'],$value['filename']); 
            }                          
        }
    }

    private function generateReports()
    {
        $reportParser = new ReportParser();
        #Parse allProductsStockCsv to Array        
        $allProductsStockArr = $reportParser->convertToArray("all-products-stock.csv");

        #Parse allProductsStockCsv to Array
        $allProductsVendorArr = $reportParser->convertToArray("all-products-vendor.csv");

        #Report 1
        $reportOne = new ReportOne();
        $reportOneResult = $reportOne->generate($allProductsStockArr,$allProductsVendorArr);

        $reportOneFilename = date("Y-m-d")."-stocks-vendor.csv";
        if($reportParser->convertToCsv($reportOneResult,$reportOneFilename)){
            if($this->myDropboxApp->uploadFile($reportOneFilename)){
                echo "Report 1 Generated!<br/>";
            }            
        }
        
        #Report 2
        $reportTwo = new ReportTwo();        
        $reportTwoResult = $reportTwo->generate($allProductsStockArr,$allProductsVendorArr);

        $reportTwoFilename = date("Y-m-d")."-vendor-withstocks.csv";
        if($reportParser->convertToCsv($reportTwoResult,$reportTwoFilename)){
            if($this->myDropboxApp->uploadFile($reportTwoFilename)){
                echo "Report 2 Generated!<br/>";
            }
        }        

        #Report 3
        $reportThree = new ReportThree();
        $reportThreeResult = $reportThree->generate($allProductsStockArr,$allProductsVendorArr);
        
        $reportThreeFilename = date("Y-m-d")."-stocks-vendor-withoutstocks.csv";
        if($reportParser->convertToCsv($reportThreeResult,$reportThreeFilename)){
            if($this->myDropboxApp->uploadFile($reportThreeFilename)){
                echo "Report 3 Generated!<br/>";
            }
        }

        #Report 4
        $reportFour = new ReportFour();
        $reportFourResult = $reportFour->generate($allProductsStockArr,$allProductsVendorArr);
        
        $reportFourFilename = date("Y-m-d")."-vendor-totalstocks.csv";
        if($reportParser->convertToCsv($reportFourResult,$reportFourFilename)){
            if($this->myDropboxApp->uploadFile($reportFourFilename)){
                echo "Report 4 Generated!<br/>";
            }
        }
    }
}