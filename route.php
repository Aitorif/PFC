<?php
class Route
{
    private $basepath;
    private $uri;
    private $base_url;
    private $routes;
    private $route;
    private $params;
    private $get_params;
    /*private $home_file = 'picadillo-landing.php';
    private $rutasArr = array('landing');
    private $headerMenuArr = array('landing');*/
    private $home_file = 'home.php';
    private $rutasArr = array("home", "login", "editor");

    
    public function __construct($get_params = false) {
        $this->get_params = $get_params;
    }
    public function getBackFile() {
        if (strlen($this->routes[1]) ==0) {
            return $this->home_file;
        };
        if ($this->getValidateBackRoute() == false) {
            return $this->home_file;
        }
        return $this->routes[1] .'.php';
    }
    public function getFile() {
        if(isset($_COOKIE["login"]) && $_COOKIE["login"] == "loged"){
            return $this->rutasArr[2].'.php';
        }else{
            if (sizeof($this->routes)>1 && strlen($this->routes[1]) ==0) {
                return $this->home_file;
            };
            if ($this->getValidateRoute() == false) {
                return $this->home_file;
            }
            return $this->routes[1] .'.php';
        }
        
    }
    public function getRoute() {
        if (sizeof($this->routes)>1 && strlen($this->routes[1]) ==0) {
            return 'index';
        };
        return sizeof($this->routes)>1 ? $this->routes[1] : 'index';
    }
    public function getRoutes() {
        $this->base_url = $this->getCurrentUri();
        $this->routes = explode('/', $this->base_url);
        $this->getParams(); //invocamos el neuvo método

        if ($this->getValidateRoute() == true ||$this->getValidateBackRoute() == true ) {
            return $this->routes;
        }
        return [ 'index' ];
    }
    private function getCurrentUri() {
        $this->basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
        $this->uri = substr($_SERVER['REQUEST_URI'], strlen($this->basepath));
        if ($this->get_params) {
            $this->getParams();
        } else {
            if (strstr($this->uri, '?')) {
                $this->uri = substr($this->uri, 0, strpos($this->uri, '?'));
            }
        }
        $this->uri = '/' . trim($this->uri, '/');
        return $this->uri;
    }
    private function getValidateRoute() {
        return  sizeof($this->routes)>1 && (in_array($this->routes[1], $this->rutasArr))  ? true : false ;
    }
    public function getValidateMenuHeader() {
        return  sizeof($this->routes)>1 && (in_array($this->routes[1], $this->headerMenuArr))  ? true : false ;
    }
    public function getValidateBackRoute() {
        return  sizeof($this->routes)>1 && (in_array($this->routes[1], $this->rutasArr))  ? true : false ;
    }

    private function getParams() {
        if (strstr($this->uri, '?')) {
            $params = explode("?", $this->uri);
            $params = $params[1];
            parse_str($params, $this->params);
            $this->routes[0] = $this->params;
            array_pop($this->routes);
        }
    }
    public function getBaseUrl() {
        $url = "localhost/clinica_castineira/";
        $url .=    "";
        return $url;
    }
    public function getEvalImage($file) {
        return $file;
        if (file_exists($file)) {
            return $file;
        } else {
            return $this->getBaseUrl() .'/img/image-not-found.jpg' ;
        }
    }
}