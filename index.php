<?php
include "router.php";

Router::make("home", [
    "pattern" => "/", 
    "controller" => "HomeController", 
    "method" => "index", 
    "request_method" => "GET",
    "params" => []
]);
Router::make("users", [
    "pattern" => "/users/", 
    "controller" => "UserController", 
    "method" => "index", 
    "request_method" => "GET", 
    "params" => []
]);
Router::make("user", [
    "pattern" => "/user/([0-9])", 
    "controller" => "UserController", 
    "method" => "details", 
    "request_method" => "GET", 
    "params" => [1 => "a", 2 => "b", 3 => "c", 4 => "d"]
]); 
Router::route();

