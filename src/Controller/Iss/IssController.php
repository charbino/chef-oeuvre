<?php
declare(strict_types=1);

namespace App\Controller\Iss;

use App\Client\IssClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class IssController
 * @package App\Controller\Iss
 *
 * @author Sébastien Framinet <sebastien.framinet@asdoria.com>
 */
#[Route(path: '/iss', name: 'iss')]
class IssController extends AbstractController
{
    #[Route('/index', name: '_index')]
    public function index(Request $request, SessionInterface $session): Response
    {
        return $this->render('iss/index.html.twig');
    }

    /**
     * @param Request $request
     * @param IssClient $client
     *
     * @return JsonResponse|AccessDeniedException
     * @throws \Exception
     */
    #[Route('/position', name: '_position', options: ['expose' => true])]
    public function getPosition(Request $request, IssClient $client)
    {
        if (!$request->isXmlHttpRequest()) {
            return new AccessDeniedException();
        }

        $result = $client->getCurrentPosition();

        return new JsonResponse($result);
    }

}
