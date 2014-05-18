<?php
class Router { 
    private static $routes = [];
    private static $request = null;
    public function __construct() {}
    public static function make($name, array $args) {
         self::$routes[$name] = $args;
    }
    public static function route() {
        $params = [];
        self::handle_request();
        if (class_exists(self::$request["controller"])) {
            $reflection_class = new ReflectionClass(self::$request["controller"]);
            
            if ($reflection_class->hasMethod(self::$request["method"])) {
                if (array_key_exists("params", self::$request)) $params = self::$request["params"];
                
                $reflection_method = new ReflectionMethod($reflection_class->getName(), self::$request["method"]);
                $reflection_method->invokeArgs($reflection_class->newInstance(), $params);
            } else { //TODO: make this error handling more advanced
                echo "Method not found";
            }
        } else { //TODO: make this error handling more advanced
            echo "Controller not found";   
        }
    }
    
    public static function link($name, array $params = []) {
       return self::$routes[$name]["pattern"];   
    }
    
    private static function handle_request() {
        foreach (self::$routes as $route => $options) {
            $regex = "~^" . $options["pattern"] . "$~m";
            
            if (preg_match($regex, $_SERVER["REQUEST_URI"])) 
                self::$request = $options;
        }
    }
}

class Creator {
    public static function create($class, $method,array $params = []) {       
        $reflection_method = new ReflectionMethod($class,$method);
        return $reflection_method->invokeArgs(new $class, $params);
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
    public function details($one, $two, $three, $four) {
        echo Router::link("user");
        echo "<br>";
        echo $one . $two . $three . $four;
    }
   // public function getUser($id)
}