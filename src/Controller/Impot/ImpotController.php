<?php
declare(strict_types=1);

namespace App\Controller\Impot;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ImpotController
 * @package App\Controller\Impot
 *
 * @author Sébastien Framinet <sebastien.framinet@asdoria.com>
 */
#[Route(path: '/', name: 'impots')]
class ImpotController extends AbstractController
{

    #[Route('/impots', name: '_index')]
    public function impot(Request $request, SessionInterface $session): Response
    {

        return $this->render('impots/impots.html.twig');
    }
}
