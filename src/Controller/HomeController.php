<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends UserAwareController
{
    /**
     * @Route("/", name="home", methods={"GET", "POST", "PUT", "PATCH"})
     * @return Response
     */
    public function welcome(): Response
    {
        return $this->render(
            'home/welcome.html.twig'
        );
    }
}
