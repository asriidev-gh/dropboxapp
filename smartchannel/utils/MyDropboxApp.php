<?php
namespace App\Utils;

use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxApp;

class MyDropboxApp {    
    private $appKey;
    private $appSecret;
    private $appToken;
    private $dropbox;

    public function __construct($appKey,$appSecret,$appToken)
    {
        $this->appKey = $appKey;
        $this->appSecret = $appSecret;
        $this->appToken = $appToken;
    }

    public function connect(){
        //Configure Dropbox Application
        $app = new DropboxApp($this->appKey, $this->appSecret, $this->appToken);
               
        //Configure Dropbox service
        $this->dropbox = new Dropbox($app);
        try{
            if($this->dropbox->getCurrentAccount()){
                return true;
            }
        }catch(Exception $e){
            echo $e->getMessage();
        }

        return true;        
    }

    public function downloadFile($dropboxFolderPath,$downloadedFilename)
    {
        $file = $this->dropbox->download($dropboxFolderPath);

        //File Contents
        $contents = $file->getContents();

        //Save file contents to disk        
        file_put_contents(__DIR__."/../downloads/" . $downloadedFilename, $contents);       
    }
    
    public function uploadFile($uploadFilename)
    {
        $file = $this->dropbox->upload(__DIR__."/../uploads/".$uploadFilename, "/Devtest/Reports/".$uploadFilename, ['autorename' => true]);        
        if($file->server_modified){
            return true;
        }
        return false;
    }
}