<?php


namespace App\Controller;


use App\View\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGenerator;

abstract class Controller implements IController
{
    protected $view;
    protected $generator;

    public function render($path, $data = [], $headers = [])
    {
        return new Response($this->view->make($path, $data),Response::HTTP_OK, $headers);
    }

    public function __construct()
    {
        $this->view = new View();
        $this->generator = new UrlGenerator(app()->getRoutes(), app()->getRequestContext());
    }
}