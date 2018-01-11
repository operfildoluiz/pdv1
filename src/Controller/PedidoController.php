<?php

namespace App\Controller;

use App\Entity\ItemPedido;
use App\Entity\Pedido;
use App\Entity\Pessoa;
use App\Entity\Produto;
use App\Model\Validators\PedidoValidator;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PedidoController extends Controller {

    /**
     * @Route("/pedido", name="pedido_index")
     */
    public function list(Request $request) {

        $em = $this->getDoctrine()->getManager();

        $pedidos = $em->getRepository(Pedido::class)->findAll();

        $message = $request->request->get('message') ?? null;

        return $this->render('pedido/list.html.twig', ['pedidos' => $pedidos, 'message' => $message]);
    }

    /**
     * @Route("/pedido/search", name="pedido_search")
     */
    public function search(Request $request) {

        if ($request->request->get('term') == null)
            return $this->redirectToRoute('pedido_index', ['message' => "Digite um termo para a busca"]);

        $em = $this->getDoctrine()->getManager();

        $pedidos = $em->getRepository(Pedido::class)->findByTerm($request->request->get('term'));

        return $this->render('pedido/list.html.twig', ['pedidos' => $pedidos]);
    }

    /**
     * @Route("/pedido_details/{id}", name="pedido_details")
     */
    public function details($id) {

        $em = $this->getDoctrine()->getManager();

        $pedido = $em->getRepository(Pedido::class)->find($id);

        if(!$pedido)
            return $this->redirectToRoute('pedido_index', ['message' => "Esse pedido não foi encontrado"]);

        return $this->render('pedido/view.html.twig', ['pedido' => $pedido]);

    }

    /**
     * @Route("/pedido/create", name="pedido_create")
     */
    public function create() {

        return $this->render('pedido/create.html.twig');
    }

    /**
     * @Route("/pedido/register", name="pedido_store")
     */
    public function store(Request $request) {

        $em = $this->getDoctrine()->getManager();

        $objetoPedido = new PedidoValidator();
        $objetoPedido->setClienteId($request->request->get('cliente_id'));
        $objetoPedido->setItems($request->request->get('items'));
        $objetoPedido->setTotal($request->request->get('total'));
        $errors = $objetoPedido->validate();

        if ($errors) {

            return $this->json(['errors' => $errors]);
        }

        $pedido = new Pedido();
        $clientePedido = $em->getRepository(Pessoa::class)->find($objetoPedido->getClienteId());
        $pedido->setCliente($clientePedido);
        $pedido->setEmissao(new \DateTime("now"));
        $pedido->setTotal($objetoPedido->getTotal());

        try {

            $em->persist($pedido);
            $em->flush();

            if ($pedido->getId()) {

                foreach ($request->request->get('items') as $item) {

                    $itemPedido = new ItemPedido();
                    $itemPedido->setPedido($pedido);
                    $produto = $em->getRepository(Produto::class)->find($item['produto_id']);
                    $itemPedido->setProduto($produto);
                    $itemPedido->setQuantidade($item['quantidade']);
                    $itemPedido->setPercentualDesconto($item['percentualDesconto']);
                    $itemPedido->setPrecoUnitario($item['precoUnitario']);
                    $itemPedido->setTotal($item['total']);

                    try {

                        $em->persist($itemPedido);
                        $em->flush();

                    } catch (\PDOException $e) {

                        return $this->json(['errors' => array('O item não pode ser cadastrado')]);
                    }
                }
            }

        } catch (\PDOException $e) {

           return $this->json(['errors' => array('Algo inesperado ocorreu')]);
        }


       return $this->json(['message' => 'success']);

   }

     /**
     * @Route("/pedido/delete/{id}", name="pedido_delete")
     */
       public function delete(string $id) {

        $em = $this->getDoctrine()->getManager();

        $pedido = $em->getRepository(Pedido::class)->find($id);

        if (!$pedido)
            return $this->redirectToRoute('pedido_index', ['message' => "Esse pedido não foi encontrado"]);

        try {

            $em->remove($pedido);
            $em->flush();

        } catch (\Exception $e) {

            return $this->redirectToRoute('pedido_index', ['message' => "Um erro inesperado aconteceu"]);
        }


        return $this->redirectToRoute('pedido_index', ['message' => "Pedido removido com sucesso"]);
    }
}
