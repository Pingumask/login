<?php
match(true){
    (routeMatch('home') || $_ROUTE==="/")=>HomeController::index(),
    
    routeMatch('user/sign-up')=>UserController::signUp(),
    routeMatch('user/handle/sign-up')=>UserController::handleSignUp($_POST),
    routeMatch('user/log-in')=>UserController::logIn(),
    routeMatch('user/options')=>UserController::options(),
    routeMatch('user/handle/log-in')=>UserController::handleLogIn($_POST),
    routeMatch('(user/)?(handle/)?log-out')=>UserController::handleLogOut(),

    default=>ErrorController::e404(),
};