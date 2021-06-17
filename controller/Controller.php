<?php
abstract class Controller{
    protected static function render(string $page, array $vars=[]){
        foreach($vars as $key=>$value){
            $$key=$value;
        }
        include('../view/template.php');
    }
}