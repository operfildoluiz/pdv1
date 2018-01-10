<?php

namespace App\Controller;

use App\Entity\Pessoa;
use App\Model\Validators\PessoaValidator;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PessoaController extends Controller {

    /**
     * @Route("/pessoa", name="pessoa_index")
     */
    public function list(Request $request) {

        $message = $request->request->get('message') ?? null;

        $em = $this->getDoctrine()->getManager();

        $pessoas = $em->getRepository(Pessoa::class)->findAll();

        if ($request->request->get('api') != null) {

            return $this->json($pessoas);
        }

        return $this->render('pessoa/list.html.twig', ['pessoas' => $pessoas, 'message' => $message]);
    }

    /**
     * @Route("/pessoa/search", name="pessoa_search")
     */
    public function search(Request $request) {

        if ($request->request->get('term') == null)
            return $this->redirectToRoute('pessoa_index', ['message' => "Digite um termo para a busca"]);

        $em = $this->getDoctrine()->getManager();

        $pessoas = $em->getRepository(Pessoa::class)->findByTerm($request->request->get('term'));

        return $this->render('pessoa/list.html.twig', ['pessoas' => $pessoas]);
    }

    /**
     * @Route("/pessoa/create", name="pessoa_create")
     */
    public function create() {

        return $this->render('pessoa/create.html.twig');
    }

    /**
     * @Route("/pessoa/store", name="pessoa_store")
     * @Method({"POST"})
     */
    public function store(Request $request) {

        $em = $this->getDoctrine()->getManager();

        $objetoPessoa = new PessoaValidator();
        $objetoPessoa->setId($request->request->get('id'));
        $objetoPessoa->setNome($request->request->get('nome'));
        $objetoPessoa->setDataNascimento($request->request->get('dataNascimento'));
        $errors = $objetoPessoa->validate(false);


        if ($errors) {

            return $this->render('pessoa/create.html.twig', ['errors' => $errors]);
        }

        $pessoa = new Pessoa();
        $pessoa->setNome($objetoPessoa->getNome());
        $pessoa->setDataNascimento($objetoPessoa->getDataNascimento(true));

        try {

            $em->persist($pessoa);
            $em->flush();

        } catch (UniqueConstraintViolationException $e) {

            return $this->render('pessoa/create.html.twig', ['duplicado' => $errors]);
        }

        return $this->redirectToRoute('pessoa_index', ['message' => "Cliente cadastrado com sucesso"]);
    }

    /**
     * @Route("/pessoa/update/{id}", name="pessoa_update")
     */
    public function update(string $id) {

        $em = $this->getDoctrine()->getManager();

        $pessoa = $em->getRepository(Pessoa::class)->find($id);

        if (!$pessoa)
            return $this->redirectToRoute('pessoa_index', ['message' => "Esse cliente não foi encontrado"]);


        return $this->render('pessoa/update.html.twig', ['pessoa' => $pessoa]);
    }

    /**
     * @Route("/pessoa/edit", name="pessoa_edit")
     * @Method({"POST"})
     */
    public function edit(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $pessoa = $em->getRepository(Pessoa::class)->find($request->request->get('id'));

        if (!$pessoa && $request->request->get('id') == null)
            return $this->redirectToRoute('pessoa_index', ['message' => "Esse cliente não foi encontrado"]);

        $objetoPessoa = new PessoaValidator();
        $objetoPessoa->setId($request->request->get('id'));
        $objetoPessoa->setNome($request->request->get('nome'));
        $objetoPessoa->setDataNascimento($request->request->get('dataNascimento'));
        $errors = $objetoPessoa->validate(true);

        if ($errors) {

            return $this->render('pessoa/update.html.twig', ['pessoa' => $pessoa, 'errors' => $errors]);
        }

        $pessoa->setNome($objetoPessoa->getNome());
        $pessoa->setDataNascimento($objetoPessoa->getDataNascimento(true));

        try {

            $em->flush();

        } catch (UniqueConstraintViolationException $e) {

            return $this->render('pessoa/update.html.twig', ['pessoa' => $pessoa, 'duplicado' => $errors]);
        }

        return $this->redirectToRoute('pessoa_index', ['message' => "Cliente editado com sucesso"]);
    }


    /**
     * @Route("/pessoa/delete/{id}", name="pessoa_delete")
     */
    public function delete(string $id) {

        $em = $this->getDoctrine()->getManager();

        $pessoa = $em->getRepository(Pessoa::class)->find($id);

        if (!$pessoa)
            return $this->redirectToRoute('pessoa_index', ['message' => "Esse cliente não foi encontrado"]);

        try {

            $em->remove($pessoa);
            $em->flush();

        } catch (\Exception $e) {

            if ($e->getErrorCode() == 1451)
                return $this->redirectToRoute('pessoa_index', ['message' => "Esse cliente não pode ser removido pois existe um pedido que o contém."]);

            return $this->redirectToRoute('pessoa_index', ['message' => "Um erro inesperado aconteceu"]);
        }


        return $this->redirectToRoute('pessoa_index', ['message' => "Cliente removido com sucesso"]);
    }
}
