<?php
require_once("API.php");
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$api = new API($actual_link);
$action = strtolower(trim(str_replace("/","",$_REQUEST['action'])));
if($action=="create"){
    $api->createTrip();
}
elseif($action=="add"){
    $request = $api->getRequest();
    if($request["tripid"]!=null){
        $api->AddFlight($request["tripid"]);
    }
}
elseif($action=="remove"){
    $request = $api->getRequest();
    if($request["tripid"]!=null){
        $api->RemoveFlight($request["tripid"]);
    }
}
