<?php

namespace App;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Loader\PhpFileLoader;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Config\FileLocator;

class Application
{
    /** @var string */
    private $basePath;
    /** @var Request */
    private $request;
    /** @var Router */
    private $router;
    /** @var EventDispatcher */
    private $dispatcher;
    /** @var RouteCollection */
    private $routes;
    /** @var RequestContext */
    private $requestContext;

    /** @var Application */
    public static $instance = null;

    private $container = [];

    public static function getInstance($basepath)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static($basepath);
        }
        return static::$instance;
    }

    private function __construct($basepath)
    {
        $this->basePath = $basepath;
        $this->request = Request::createFromGlobals();
        $this->dispatcher = new EventDispatcher();
//        $this->dispatcher->addListener(KernelEvents::REQUEST, function () {
//            echo 'KernelEvents::REQUEST<br>';
//        });
        $this->requestContext = new RequestContext();
        $this->requestContext->fromRequest($this->request);

        $this->router = new Router(
            new PhpFileLoader(new FileLocator([__DIR__])),
            $this->basePath . '/src/routes.php',
            ['cache_dir' => $this->basePath . '/cache']
        );
        $this->routes = $this->router->getRouteCollection();
    }

    public function run()
    {
        $this->dispatcher->addSubscriber(
            new RouterListener(
                new UrlMatcher($this->routes, $this->requestContext),
                new RequestStack()
            )
        );
        $kernel = new HttpKernel($this->dispatcher, new ControllerResolver(), new RequestStack(), new ArgumentResolver());
        try {
            $response = $kernel->handle($this->request);
        } catch (NotFoundHttpException $e) {
            exit('Запрашиваемая страница не существует');
        } catch (\Exception $e) {
            exit($e->getMessage());
        }
        $response->send();
        $kernel->terminate($this->request, $response);
    }

    public function add($key, $object)
    {
        $this->container[$key] = $object;
        return $object;
    }

    public function get($key)
    {
        if (isset($this->container[$key])) {
            return $this->container[$key];
        }
        return null;
    }

    /**
     * @return RouteCollection
     */
    public function getRoutes(): RouteCollection
    {
        return $this->routes;
    }

    /**
     * @return RequestContext
     */
    public function getRequestContext(): RequestContext
    {
        return $this->requestContext;
    }
}