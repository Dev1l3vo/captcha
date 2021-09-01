<?php

function GenerateString($len){
    return substr(sha1(rand()), 0, $len);
}


?>