<?php
function routeMatch(string $path){
    global $_ROUTE;
    return (Boolean)preg_match('`^/'.$path.'/?$`',$_ROUTE);
}