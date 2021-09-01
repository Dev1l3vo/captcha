<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('php/GeneratCap.php');
$reqMeth = $_SERVER['REQUEST_METHOD'];
$genCap = new  GenerateCap();
$genCap->setMaxLen(5);

if ($reqMeth == 'GET') {
    header('Content-type: application/json');
    $genCap->GenerateImage();
    $imgEncoded= base64_encode(file_get_contents('captcha/file.png'));
    echo json_encode(array("photoEncode"=>$imgEncoded));
   
} else if ($reqMeth == 'POST') {
    if (isset($_POST['submitBtn'])) {
        if(md5($_POST['txtBox']) == $_COOKIE['captcha']){
            echo "The captcha was guessed";
        }else{
            echo "The captcha was dont guessed";
        }
    }
}
?>