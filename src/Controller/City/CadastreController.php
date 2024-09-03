<?php
declare(strict_types=1);

namespace App\Controller\City;

use App\Client\CadastreClient;
use League\Csv\Reader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CadastreController
 * @package App\Controller\City
 *
 * @author Sébastien Framinet <sebastien.framinet@asdoria.com>
 */
#[Route(path: '/cadastre', name: 'cadastre')]
class CadastreController extends AbstractController
{

    #[Route(path: '/city-informations', name: '_get_city_informations', options: ['expose' => true], methods: ['GET'])]
    public function getCityInformations(Request $request, CadastreClient $cadastreClient)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new HttpException(403, "Forbidden");
        }

        $query = $request->query->get('query');
        $city = $cadastreClient->getCity($query);
        $plots = null;
        $parcelles = null;
        if (!empty($city)) {
            $plots = $cadastreClient->getPlots($city->features[0]);
            $parcelles = $cadastreClient->getParcelles($city->features[0]);
        }

        return new JsonResponse(['city' => $city->features[0], 'plots' => $plots, 'parcelles' => $parcelles]);
    }
}
