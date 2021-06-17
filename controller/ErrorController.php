<?php
require_once("../controller/Controller.php");
class ErrorController extends Controller{
    public static function e404(){
        self::render("error/404.php");
    }
}