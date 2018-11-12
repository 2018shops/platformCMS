<?php
/**
 * Created by PhpStorm.
 * User: wangjh
 * Date: 2018/4/4
 * Time: 08:07
 */

$obj = new Html2Weex();
$html = '';
$json = $obj->render($html);
echo $json;

class Html2Weex {

    public function render($html)
    {
        $ht =  strip_tags($html);
        print_r('<pre>');
        print_r($ht);
        exit(0);
    }
    


}




