<?php
namespace app\core;
class Router
{
    protected array $routes = [];
    public Request $request;
    public Response $response;

    /**
     * @param Request $request
     */
    public function __construct(Request $request, Response  $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public  function  get($path,$callback){
        $this->routes['get'][$path] = $callback;
    }

    public  function  post($path,$callback){
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback === false){
            $this->response->setResponseCode(404);
            return $this->renderView("_404");
        }
        if(is_string($callback)){
            return $this->renderView($callback);
        }
        if(is_array($callback)){
            Application::$app->controller = new $callback[0];
            $callback[0] = Application::$app->controller;
        }
//        echo "<pre>";
//        var_dump($callback);
        return call_user_func($callback,$this->request);
    }

    public function renderView(string $view,$params=[])
    {
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view,$params);
        return str_replace("{{content}}", $viewContent, $layoutContent);
    }

//    public function renderContent($content)
//    {
//        $layoutContent = $this->layoutContent();
//        return str_replace("{{content}}", $content, $layoutContent);
//    }
//
    public function layoutContent()
    {
        $layout = Application::$app->controller->layout;
        ob_start();
        include_once Application::$ROOT_DIR."/views/layouts/$layout.php";
        return ob_get_clean();
    }

    public function renderOnlyView(string $view, $params )
    {
        foreach ($params as $key => $value){
            $$key = $value;
        }
        ob_start();
        include_once Application::$ROOT_DIR."/views/$view.php";
        return ob_get_clean();
    }
}