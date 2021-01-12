<?php


namespace app\controllers;


use app\core\Application;
use app\core\Request;

class SiteController extends Controller
{
    public function home()
    {
        $params = [
            'name' => "Amaframe"
        ];
        return $this->render('home', $params);
    }

    public function contact()
    {
        return Application::$app->router->renderView('contact');
    }

    public function handleContact(Request $request)
    {
        $Body = $request->getBody();
        echo '<pre>';
        var_dump($Body);
        echo '</pre>';
        exit;
        return 'Handling submitted data';
    }
}
