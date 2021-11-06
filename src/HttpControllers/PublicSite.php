<?php
declare(strict_types = 1);

namespace App\HttpControllers;

use Apex\Svc\View;
use Apex\Armor\Armor;
use Nyholm\Psr7\Response;
use Psr\Http\Message\{ServerRequestInterface, ResponseInterface};
use Psr\Http\Server\{MiddlewareInterface, RequestHandlerInterface};
use Symfony\Component\Process\Process;

/**
 * Default http controller, generally intended to serve public web site.
 */
class PublicSite implements MiddlewareInterface
{

    #[Inject(View::class)]
    private View $view;

    #[Inject(Armor::class)]
    private Armor $armor;

    /**
     * Process request
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $app): ResponseInterface
    {

        // Check authentication
        if (is_dir(SITE_PATH . '/src/Users') && $session = $this->armor->checkAuth()) { 
            $app->setSession($session);
            $this->view->assign('profile', $session->getUser()->toDisplayArray());
        }

        // Render template via auto-routing based on URI being viewed
        $file = $this->view->doAutoRouting($app->getPath());
        $html = $this->view->render($file);

        // Create response
        $code = str_ends_with($file, '404.html') ? 404 : 200;
        return new Response($code, [], $html);
    }

}



