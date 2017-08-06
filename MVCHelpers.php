<?php

function includeScripts($folder){
    foreach (glob("$folder/*.js") as $filename)
    {
        echo "<script src='$filename'></script>\n";
    }
}

function includeCss($folder){
    foreach (glob("$folder/*.css") as $filename)
    {
        echo "<link rel='stylesheet' href='$filename'>\n";
    }
}

function View($Model = ""){
    ob_start();
    $view = "Views/".$GLOBALS["Controller"]."/".$GLOBALS["Action"];
    if(file_exists($view).".phtml")
        $view.=".phtml";
    else if(file_exists($view).".phtm")
        $view.=".phtm";
    else if(file_exists($view).".php")
        $view.=".php";
    else
        $view.=".html";
    include $view;
    if(!isset(View::$Bag["content"]))
        View::$Bag["content"] = ob_get_contents();
    ob_end_clean();
    include "Views/start.phtml";
}

function PartialView($Model = ""){
    include "Views/".controller()."/".action().".phtml";
}

function Redirect($ControllerName = "Home", $Action = "Index"){
    $ControllerName = $ControllerName . "Controller";
    $Controller = new $ControllerName;
    $GLOBALS["Controller"] = $Controller;
    $GLOBALS["Action"] = $Action;
    $Controller->$Action();
}

function Get($ControllerName = "Home", $Action = "Index"){
    $_SERVER['REQUEST_METHOD'] = "GET";
    Redirect($ControllerName, $Action);
}

function Post($ControllerName = "Home", $Action = "Index"){
    $_SERVER['REQUEST_METHOD'] = "POST";
    Redirect($ControllerName, $Action . "Post");
}

function JsonResult($Model = []){
    return json_encode($Model);
}

function Error($exception){
    include "Views/Shared/ErrorPage.phtml";
}