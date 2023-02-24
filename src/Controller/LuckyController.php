<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyController extends AbstractController
{
    #[Route('/lucky/number', name: 'lucky')]

    public function number(): Response
    {
        $number = random_int(0, 100);
        $dagen=["maandag","dinsdag","woensdag","donderdag","vrijdag"];
        return $this->render('bezoeker/number.html.twig',
            ['number'=>$number,
               'days'=>$dagen ]);
    }

    #[Route('/goedemorgen', name: 'goede_morgen')]

    public function goedemorgenAction():Response
    {
        return $this->render('bezoeker/goedemorgen.html.twig');
    }
}