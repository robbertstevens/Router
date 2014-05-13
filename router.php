<?php
class Router { 
    private static $routes = [];
    private static $request = null;
    public function __construct() {}
    public static function make($name, array $args) {
         self::$routes[$name] = $args;
    }
    public static function route() {
        self::handle_request();
        if (class_exists(self::$request["controller"])) {
            $controller = new self::$request["controller"]();
            if (method_exists($controller, self::$request["method"])) {
                $method =self::$request["method"];
                $controller->$method();//
            } else { //TODO: make this error handling more advanced
                echo "Method not found";
            }
        } else { //TODO: make this error handling more advanced
            echo "Controller not found";   
        }
    }
    public static function link($name, array $arg = null) {
        return self::$routes[$name]["pattern"];   
    }
    private static function handle_request() {
        foreach (self::$routes as $route => $options) {
            $regex =  $options["pattern"];
            $regex = "~^" .$regex . "$~m";
            
            if (preg_match($regex, $_SERVER["REQUEST_URI"])) 
                self::$request = $options;
        }
    }
}

class HomeController {
    public function index() {
        echo Router::link("home");
    }
   // public function getUser($id)
}

class UserController {
    public function index() {
        echo Router::link("users");
    }
    public function details() {
        echo Router::link("user");
    }
   // public function getUser($id)
}