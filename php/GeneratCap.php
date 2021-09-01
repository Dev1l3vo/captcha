<?php
require_once('GenerateString.php');
class GenerateCap {
    const FONT_NAME= "arial.ttf";
    private $text;
    private $maxLen = 5;//default maxLen 5
    private $fontSize =50;//dafult fontSize 15
    private $imageProp = array('height'=>150,'width'=>260);
    public function __construct()
    { }

    public function setMaxLen($maxLen){//set max len of gener text
        if(is_integer($maxLen)){
            $this->maxLen = $maxLen;
        }
    }

    public function setFontSize($fontSize){//set max len of gener text
        if(is_integer($fontSize)){
            $this->fontSize = $fontSize;
        }
    }

    private function setText(){//set generated text in image
        $text = GenerateString($this->maxLen);
        if(is_string($text) && strlen($text)==$this->maxLen){
            $this->text = $text;
        }
    }

    public function GenerateImage(){
        $this->setText();
        $img = null;
        $midY = (int)($this->imageProp['height']/2);
        if(!($img = imagecreatefrompng('white_noise.png'))){
            echo "Error with creating img";
        }

        for($i=0;$i<$this->maxLen;$i++){
            list($red,$green,$blue) = $this->GenerateColors();//generate text color
            $textColor = imagecolorallocate($img,$red,$green,$blue);//create textColor object
            if(!imagettftext($img,$this->fontSize,0,$this->fontSize*$i,$midY,$textColor,'arial.ttf',$this->text[$i])){//one symbol has width 10 pix and the next pix has cord start_pos+width_sym*curr_numSym
                echo "problem with adding text";
            }
        }


        if(imagesx($img)!=$this->imageProp['width'] || imagesy($img)!=$this->imageProp['height']){
            $im2 = imagecrop($img, ['x' => 0, 'y' => 0, 'width' => $this->imageProp['width'], 'height' => $this->imageProp['height']]);
            if($im2!==false){
                imagepng($im2,"captcha/file.png",9);
                imagedestroy($im2);
            }
        }
        imagedestroy($img);
        setcookie("captcha",md5($this->text),time()+30);
    }

    private function GenerateColors(){
        $color = array();
        for($i=0;$i<3;$i++){
            array_push($color,$this->GenerateNumber(0,255));
        }
        return $color;
    }

    private function GenerateNumber($min,$max){
        return rand($min,$max);
    }

}
?> 