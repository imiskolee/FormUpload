<?php
/***
 * RFC http://www.ietf.org/rfc/rfc1867.txt implement for PHP
 *
 * HTML Form表单上传multipart/form-data的PHP实现
 * @author misko_lee
 * @version 0.1.0
 * @email imiskolee@gmial.com
 */
class FormUpload
{

    static $MIME_JPEG = 'image/jpeg';
    static $MIME_PNG = 'image/png';
    static $MIME_BMP ='image/bmp';
    static $MIME_TEXT = 'text/plan';
    static $MIME_HTML = 'text/html';

    private $boundary = '';
    private $payload = '';
    private $url = '';
    private $curl = null;
    public function __construct($url = ''){
        $this->init();

        $this->url = $url;
    }

    public function init(){
        $this->boundary = $this->genBoundary();
        $this->payload = '';
        $this->curl = curl_init();
    }

    public function setCUrlOpt($opt,$val){
        curl_setopt($this->curl,$opt,$val);
    }

    public function addPart($name,$value = '',$mimeType = '',$fileName=''){
        $line = '';
        if(!$mimeType){
            $line =sprintf("%s\nContent-Disposition: form-data; name=\"%s\"\n\n%s\n",
                $this->boundary,
                $name,
                $value
            );
        }else{
            if(!$fileName){
                $fileName = rand(1000,9999).rand(1000,9999).rand(1000,9999);
            }
            $line =sprintf("%s\nContent-Disposition: form-data; name=\"%s\"; filename=\"%s\"\nContent-Type: %s\n\n%s\n",
                $this->boundary,
                $name,
                $fileName,
                $mimeType,
                $value
            );
        }
        $this->payload .= $line;
    }

    public function getHeader(){
        return   'Content-type:multipart/form-data; boundary='.substr($this->boundary,2,strlen($this->boundary));
    }
    private function genBoundary(){
        return '------CURL_FORM_UPLOAD_BOUNDARY'.rand(1000,9999).rand(1000,9999);
    }
    public function getPayload(){
        return $this->payload.$this->boundary."\n\r";
    }

    public function submit(){
        $headers = array(
            $this->getHeader()
        );
        curl_setopt($this->curl,CURLOPT_HTTPHEADER,$headers);
        curl_setopt($this->curl,CURLOPT_POST,1);
        curl_setopt($this->curl,CURLOPT_POSTFIELDS,$this->getPayload());
        curl_setopt($this->curl,CURLOPT_URL,$this->url);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, TRUE);
        return curl_exec($this->curl);
    }
}
