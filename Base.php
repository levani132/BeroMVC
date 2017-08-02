<?php
include "MVCHelpers.php";
include "Controllers/BaseController.php";
foreach (glob("Controllers/*.php") as $filename)
{
    include_once $filename;
}
foreach (glob("Models/*.php") as $filename)
{
    include $filename;
}

class View{
    static $Bag;
}

// This is only for my test case for production should be deleted.
//$_SERVER['SERVER_NAME'] = $_SERVER['SERVER_NAME'] . "/Workspace/HikingPartners";
//$_SERVER['REQUEST_URI'] = substr($_SERVER['REQUEST_URI'], strlen("/Workspace/HikingPartners"));
// Ends here

$uri = $_SERVER["REQUEST_URI"];
View::$Bag["title"] = $uri;
$method = $_SERVER['REQUEST_METHOD'];

try{
    $uri .= "?";
    $uri = substr($uri, 0, strpos($uri, "?"));
    $uri = trim($uri, "/");
    $uris = explode("/", $uri);
    $ControllerName = !$uris[0] || $uris[0] == '' ? "Home" : $uris[0];
    $ControllerName ='Controllers\\'.$ControllerName."Controller";
    if(!class_exists($ControllerName))
        throw new Exception("Controller doesn't exist");
    $Controller = new $ControllerName;
    $Action = $uris[1] ?? "Index";
    $ActionCall = $Action;
    if($method == "POST"){
        $ActionCall = $Action + "Post";
    }
    if(count($uris) >= 3 && !isset($_GET["id"])){
        $_GET["id"] = $uris[sizeof($uris) - 1];
    }
    if(!method_exists($Controller, $ActionCall))
        throw new Exception("Action doesn't exist");
    echo $Controller->$ActionCall();
}
catch(Exception $e){
    Error($e);
}