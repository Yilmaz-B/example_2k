<?php

namespace App\Controller;

use App\Entity\Cars;
use App\Form\CarType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends AbstractController
{
    #[Route('/carform', name: 'app_car_form')]
    public function car(Request $request,EntityManagerInterface $entityManager ): Response
    {
        $car = new Cars();
        $form = $this->createForm(CarType::class, $car);
        return $this->renderForm('task/car.html.twig', ['cars' => $form]);
    }
}