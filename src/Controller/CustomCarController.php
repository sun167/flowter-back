<?php
namespace App\Controller;
use Psr\Log\LoggerInterface;

use App\Entity\Car;
use App\Repository\CarRepository;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Collection;

#[AsController]
class CustomCarController extends AbstractController
{
    #[Route(
        name: 'custom_cars',
        path: 'api/cars/departureDate={departureDate}&returnDate={returnDate}',
        methods: ['GET'],
        defaults: [
            '_api_resource_class' => Car::class,
            '_api_operation_name' => '_api_/cars/departureDate={departureDate}&returnDate={returnDate}',
        ],
    )]
    public function getCars(Request $request, CarRepository $carRepository): JsonResponse
    {
        $departureDate = new \DateTime($request->query->get('departureDate'));
        $returnDate = new \DateTime($request->query->get('returnDate'));
        // $departureSite = $request->query->get('departureSite');
        $availableCars = $carRepository->findByTimeFrame($departureDate, $returnDate);

        return $this->json($availableCars);
    }
}