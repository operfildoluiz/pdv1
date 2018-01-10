<?php

namespace App\Controller;

use App\Entity\Produto;
use App\Model\Validators\ProdutoValidator;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProdutoController extends Controller {

    /**
     * @Route("/produto", name="produto_index")
     */
    public function list(Request $request) {

        $message = $request->request->get('message') ?? null;

        $em = $this->getDoctrine()->getManager();

        $produtos = $em->getRepository(Produto::class)->findAll();

        return $this->render('produto/list.html.twig', ['produtos' => $produtos, 'message' => $message]);
    }

    /**
     * @Route("/produto/search", name="produto_search")
     */
    public function search(Request $request) {

        if ($request->request->get('term') == null)
            return $this->redirectToRoute('produto_index', ['message' => "Digite um termo para a busca"]);

        $em = $this->getDoctrine()->getManager();

        $produtos = $em->getRepository(Produto::class)->findByTerm($request->request->get('term'));

        if ($request->request->get('api') != null) {

            return $this->json($produtos);
        }


        return $this->render('produto/list.html.twig', ['produtos' => $produtos]);
    }

    /**
     * @Route("/produto/create", name="produto_create")
     */
    public function create() {

        return $this->render('produto/create.html.twig');
    }

    /**
     * @Route("/produto/store", name="produto_store")
     * @Method({"POST"})
     */
    public function store(Request $request) {

        $em = $this->getDoctrine()->getManager();

        $objetoProduto = new ProdutoValidator();
        $objetoProduto->setId($request->request->get('id'));
        $objetoProduto->setNome($request->request->get('nome'));
        $objetoProduto->setCodigo($request->request->get('codigo'));
        $objetoProduto->setPrecoUnitario($request->request->get('precoUnitario'));
        $errors = $objetoProduto->validate(false);

        if ($errors) {

            return $this->render('produto/create.html.twig', ['errors' => $errors]);
        }

        $produto = new Produto();
        $produto->setNome($objetoProduto->getNome());
        $produto->setCodigo($objetoProduto->getCodigo());
        $produto->setPrecoUnitario($objetoProduto->getPrecoUnitario());

        try {

            $em->persist($produto);
            $em->flush();

        } catch (UniqueConstraintViolationException $e) {

            return $this->render('produto/create.html.twig', ['duplicado' => $errors]);
        }

        return $this->redirectToRoute('produto_index', ['message' => "Produto cadastrado com sucesso"]);
    }

    /**
     * @Route("/produto/update/{id}", name="produto_update")
     */
    public function update(string $id) {

        $em = $this->getDoctrine()->getManager();

        $produto = $em->getRepository(Produto::class)->find($id);

        if (!$produto)
            return $this->redirectToRoute('produto_index', ['message' => "Esse produto não foi encontrado"]);


        return $this->render('produto/update.html.twig', ['produto' => $produto]);
    }

    /**
     * @Route("/produto/edit", name="produto_edit")
     * @Method({"POST"})
     */
    public function edit(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $produto = $em->getRepository(Produto::class)->find($request->request->get('id'));

        if (!$produto && $request->request->get('id') == null)
            return $this->redirectToRoute('produto_index', ['message' => "Esse produto não foi encontrado"]);

        $objetoProduto = new ProdutoValidator();
        $objetoProduto->setId($request->request->get('id'));
        $objetoProduto->setNome($request->request->get('nome'));
        $objetoProduto->setCodigo($request->request->get('codigo'));
        $objetoProduto->setPrecoUnitario($request->request->get('precoUnitario'));
        $errors = $objetoProduto->validate(true);


        if ($errors) {

            return $this->render('produto/update.html.twig', ['produto' => $produto, 'errors' => $errors]);
        }

        $produto->setNome($objetoProduto->getNome());
        $produto->setCodigo($objetoProduto->getCodigo());
        $produto->setPrecoUnitario($objetoProduto->getPrecoUnitario());

        try {

            $em->flush();

        } catch (UniqueConstraintViolationException $e) {

            return $this->render('produto/update.html.twig', ['produto' => $produto, 'duplicado' => $errors]);
        }

        return $this->redirectToRoute('produto_index', ['message' => "Produto editado com sucesso"]);
    }


    /**
     * @Route("/produto/delete/{id}", name="produto_delete")
     */
    public function delete(string $id) {

        $em = $this->getDoctrine()->getManager();

        $produto = $em->getRepository(Produto::class)->find($id);

        if (!$produto)
            return $this->redirectToRoute('produto_index', ['message' => "Esse produto não foi encontrado"]);

        try {

            $em->remove($produto);
            $em->flush();

        } catch (\Exception $e) {

            if ($e->getErrorCode() == 1451)
                return $this->redirectToRoute('produto_index', ['message' => "Esse produto não pode ser removido pois existe um pedido que o contém."]);

            return $this->redirectToRoute('produto_index', ['message' => "Um erro inesperado aconteceu"]);
        }


        return $this->redirectToRoute('produto_index', ['message' => "Produto removido com sucesso"]);
    }
}
