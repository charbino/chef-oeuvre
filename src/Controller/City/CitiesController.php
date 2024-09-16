<?php

declare(strict_types=1);

namespace App\Controller\City;

use App\Client\CityClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

#[\Symfony\Component\Routing\Attribute\Route(path: '/cities', name: 'cities')]
class CitiesController extends AbstractController
{
    #[\Symfony\Component\Routing\Attribute\Route(path: '/', name: '_index')]
    public function cities(): Response
    {
        return $this->render('city/cities.html.twig', []);
    }

    #[\Symfony\Component\Routing\Attribute\Route(path: '/city', name: '_search', options: ['expose' => true], methods: 'GET')]
    public function getCities(Request $request, CityClient $cityClient): JsonResponse
    {
        if (!$request->isXmlHttpRequest()) {
            throw new HttpException(403, 'Forbidden');
        }

        $query = $request->query->get('query', '');
        $cites = $cityClient->getCitiesByName($query);
        if ($cites === []) {
            if (strlen($query) == 2) {
                $cites = $cityClient->getCitiesByDepartmentCode($query);
            } else {
                $cites = $cityClient->getCitiesByCodePostal($query);
            }
        }

        return new JsonResponse(['cities' => $cites]);
    }

    #[\Symfony\Component\Routing\Attribute\Route(path: '/departements', name: '_search_departments', options: ['expose' => true], methods: [
        'GET',
    ])]
    public function getDepartments(Request $request, CityClient $cityClient): JsonResponse
    {
        if (!$request->isXmlHttpRequest()) {
            throw new HttpException(403, 'Forbidden');
        }

        $query = $request->query->get('query', '');
        $departments = $cityClient->getDepartmentByName($query);
        if ($departments === []) {
            $departments = $cityClient->getDepartmentByCode($query);
        }

        return new JsonResponse(['departments' => $departments]);
    }

    #[\Symfony\Component\Routing\Attribute\Route(path: '/cities-informations', name: '_get_cities_informations_from_department', options: ['expose' => true], methods: [
        'GET',
    ])]
    public function getCitiesInformationsFromDepartment(Request $request, CityClient $cityClient): JsonResponse
    {
        if (!$request->isXmlHttpRequest()) {
            throw new HttpException(403, 'Forbidden');
        }

        $query = $request->query->get('query', '');
        $cities = $cityClient->getCitiesInformationsByDepartmentCode($query);

        return new JsonResponse(['cities' => $cities]);
    }
}
