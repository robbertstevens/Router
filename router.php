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
                Controller::create(self::$request["controller"], self::$request["method"], self::$request["params"]);
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
            $regex =  $options["pattern"];
            $regex = "~^" .$regex . "$~m";
            
            if (preg_match($regex, $_SERVER["REQUEST_URI"])) 
                self::$request = $options;
        }
    }
}

class Controller {
    public static function create($class, $method,array $params = []) {       
        $reflection_method = new ReflectionMethod($class,$method);
        return $reflection_method->invokeArgs(new $class, $params);
    }
}
class HomeController extends Controller{
    public function index() {
        echo Router::link("home");
    }
   // public function getUser($id)
}

class UserController extends Controller{
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