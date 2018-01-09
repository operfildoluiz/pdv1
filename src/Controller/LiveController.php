<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LiveController extends Controller {

    /**
     * @Route("/live/{name}", name="live")
     * @Method({"GET", "POST"})
     */
    public function index(string $name) {

        return new Response("Olá, $name! Estamos ao vivo.");
    }
}
