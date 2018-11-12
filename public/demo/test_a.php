<?php
/**
 * Created by PhpStorm.
 * User: wangjh
 * Date: 2018/3/20
 * Time: 17:14
 */


class Account {
    private $user = 1;
    private $pwd  = 2 ;


    public function __set($name,$value)
    {
        $this->$name = $value;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    
}

$a = new Account();
echo $a->user;