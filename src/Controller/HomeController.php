<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller {

    /**
     * @Route("/", name="home")
     */
    public function index() {

        return $this->render('index.html.twig');
    }

    /**
     * @Route("/echo", name="echo_test")
     */
    public function test() {

        /*
         * Esse método é utilizado por tests/RoutingTest.php que verifica o roteamento.
         * Caso receba "Live", o sistema de rotas está funcionando.
         */

        return new Response("Live");
    }
}
