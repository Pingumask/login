<?php
require_once("../controller/Controller.php");
class HomeController extends Controller{
    public static function index(){
        global $_URI;
        self::render("home.php",["route"=>$_URI]);
    }
}
