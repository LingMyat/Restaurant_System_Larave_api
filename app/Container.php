<?php
namespace App;

class Container {
    protected $binding = [];

    public function bind($key,$value){
        $this->binding[$key]=$value;

    }
    public function resolve($key){
        // return call_user_func($this->binding[$key]);
        return $this->binding[$key];
    }
}
