<?php

    class Router
    {
        private $routes;

        public function __construct()
        {
            require_once ("configs/routes.php");
            $this->routes = $routes;
        }

        public function run()
        {
            $requestedUrl = $_SERVER['REQUEST_URI'];

//            echo '<pre>';
//            print_r($requestedUrl);
//            echo '</pre>';

            foreach ($this->routes as $controller=>$paths) {

//                echo '<pre>';
//                print_r($controller);
//                echo '</pre>';
//
//                echo '<pre>';
//                print_r($paths);
//                echo '</pre>';

                foreach ($paths as $url=>$actionWithParameters) {
                    if(preg_match("~$url~", $requestedUrl)) {
                    //if(SITE_ROOT . $url === $requestedUrl) {
                        $actionWithParameters = preg_replace("~$url~", $actionWithParameters,$requestedUrl);
                        $count = 1;
                        $actionWithParameters = str_replace(SITE_ROOT, '', $actionWithParameters, $count);
                        $actionWithParametersArray = explode('/', $actionWithParameters);
                        $action = array_shift($actionWithParametersArray);
                        $requestedController = new $controller();
                        $requestedAction = "action" . ucfirst($action);
                        //$requestedController->$requestedAction();
                        call_user_func_array(array($requestedController, $requestedAction), $actionWithParametersArray);
                        break 2;
                    }

                }
            }
//            echo '<pre>';
//            print_r($_SERVER);
//            echo '</pre>';
        }
    }