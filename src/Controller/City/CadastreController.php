<?php

declare(strict_types=1);

namespace App\Controller\City;

use App\Client\CadastreClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

#[\Symfony\Component\Routing\Attribute\Route(path: '/cadastre', name: 'cadastre')]
class CadastreController extends AbstractController
{
    #[\Symfony\Component\Routing\Attribute\Route(path: '/city-informations', name: '_get_city_informations', options: ['expose' => true], methods: [
        'GET',
    ])]
    public function getCityInformation(Request $request, CadastreClient $cadastreClient): JsonResponse
    {
        if (!$request->isXmlHttpRequest()) {
            throw new HttpException(403, 'Forbidden');
        }

        $query = $request->query->get('query');
        $city = $cadastreClient->getCity($query ?? '');

        if (!$city instanceof \App\Model\City\City) {
            return new JsonResponse(['error' => 'City not found'], 404);
        }

        return new JsonResponse([
            'city' => $city,
            'plots' => $cadastreClient->getPlots($city),
            'parcelles' => $cadastreClient->getParcelles($city),
        ]);
    }
}
