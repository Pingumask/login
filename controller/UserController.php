<?php
require_once("../controller/Controller.php");
require_once("../model/User.class.php");

class UserController extends Controller{    
    public static function signUp(){
        self::render("user/sign-up.php");
    }

    public static function view($params){//TODO à supprimer à la fin des tests !!!
        $user = User::loadById($params[1]);
        self::render("user/view.php",[
            "user"=>$user
        ]);
    }

    public static function logIn(){
        if (isset($_SESSION['user'])){
            header("location:/user/options/");
            exit();
        }
        self::render("user/log-in.php");
    }

    public static function options(){
        self::render("user/options.php");
    }

    public static function handleLogIn($params){
        $user=User::loadByEmailAndPassword($params['email'],$params['password']);
        if(isset($user->id_user)){
            $_SESSION['user'] = $user;  
            header("location:".$_SERVER['HTTP_REFERER']);
            exit();
        }
        $_SESSION['toastError'][]="User not found";
        header("location:".$_SERVER['HTTP_REFERER']);
    }

    public static function handleLogOut(){
        session_destroy();
        header("location:/");
    }

    public static function handleSignUp($params){
        if (
                !isset($params['nick']) 
            ||  !isset($params['email']) 
            ||  !isset($params['password']) 
            ||  !isset($params['confirmPassword'])         
            ||  $params['nick']=='' 
            ||  $params['email']=='' 
            ||  $params['password']=='' 
            ||  $params['confirmPassword']==''
        ){
            $_SESSION['toastError'][]="Form manipulation detected";
            header("location:/user/sign-up");
            exit();
        }
        if ($params['password'] !== $params['confirmPassword']){
            $_SESSION['toastError'][]="Passwords must match";
        }
        $user=new User();
        $user->nick=$params['nick'];
        $user->email=$params['email'];
        $user->setPassword($params['password']);
        if ($user->isValid($params['password'])){
            $user->save();
            $user->sendSignUpMail();
            header("location:/user/log-in");
            exit();
        }
        header("location:/user/sign-up");
    }
}