<?php 
require_once('vendor/autoload.php');

require_once(__DIR__."/smartchannel/utils/MyDropboxApp.php");
require_once(__DIR__."/smartchannel/utils/ReportParser.php");
require_once(__DIR__."/smartchannel/report/ReportOne.php");
require_once(__DIR__."/smartchannel/report/ReportTwo.php");
require_once(__DIR__."/smartchannel/report/ReportThree.php");
require_once(__DIR__."/smartchannel/report/ReportFour.php");
require_once(__DIR__."/smartchannel/ReportGenerator.php");

$app = new ReportGenerator();
$app->execute();