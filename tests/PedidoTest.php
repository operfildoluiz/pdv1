<?php

namespace App\Tests;

use App\Entity\ItemPedido;
use App\Entity\Pedido;
use App\Entity\Pessoa;
use App\Entity\Produto;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PedidoTest extends KernelTestCase
{

    private $temp_id;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->em = $kernel->getContainer()
        ->get('doctrine')
        ->getManager();

        $this->ids = null;
    }

    public function testeCreateDependencies()
    {

        $temp_name = substr(md5(mt_rand()), 0, 7);
        $temp_code= substr(md5(mt_rand()), 0, 4);

        $produto = new Produto();
        $produto->setNome('Test ' . $temp_name);
        $produto->setCodigo('TST' . $temp_code);
        $produto->setPrecoUnitario('8.88');

        $pessoa = new Pessoa();
        $pessoa->setNome('Test ' . $temp_name);
        $pessoa->setDataNascimento(new \DateTime('now'));

        $this->em->persist($produto);
        $this->em->persist($pessoa);
        $this->em->flush();

        $this->assertNotEmpty($pessoa->getId());
        $this->assertNotEmpty($produto->getId());

        $this->ids = array('pessoa_id'=>$pessoa->getId(), 'produto_id'=>$produto->getId());

        return $this->ids;
    }

    /**
     * @depends testeCreateDependencies
     */
    public function testCreatePedido($ids)
    {

        $pedido = new Pedido();
        $clientePedido = $this->em->getRepository(Pessoa::class)->find($ids['pessoa_id']);
        $pedido->setCliente($clientePedido);
        $pedido->setEmissao(new \DateTime("now"));
        $pedido->setTotal("50.00");

        $this->em->persist($pedido);
        $this->em->flush();

        $this->assertNotEmpty($pedido->getId());

        $itemPedido = new ItemPedido();
        $itemPedido->setPedido($pedido);
        $produto = $this->em->getRepository(Produto::class)->find($ids['produto_id']);
        $itemPedido->setProduto($produto);
        $itemPedido->setQuantidade('1.00');
        $itemPedido->setPercentualDesconto('1.00');
        $itemPedido->setPrecoUnitario('8.88');
        $itemPedido->setTotal('8.88');

        $this->em->persist($itemPedido);
        $this->em->flush();

        $this->assertNotEmpty($itemPedido->getId());

        $this->ids = array(
            'pessoa_id'=> $ids['pessoa_id'],
            'produto_id'=> $ids['produto_id'],
            'pedido_id'=> $pedido->getId()
            );

        return $this->ids;
    }

    /**
     * @depends testCreatePedido
     */
    public function testRemove($ids)
    {
        $pedido = $this->em->getRepository(Pedido::class)->find($ids['pedido_id']);
        $this->em->remove($pedido);

        $produto = $this->em->getRepository(Produto::class)->find($ids['produto_id']);
        $this->em->remove($produto);

        $pessoa = $this->em->getRepository(Pessoa::class)->find($ids['pessoa_id']);
        $this->em->remove($pessoa);

        $this->em->flush();

        $pedido_after = $this->em->getRepository(Pedido::class)->find($ids['pedido_id']);
        $produto_after = $this->em->getRepository(Produto::class)->find($ids['produto_id']);
        $pessoa_after = $this->em->getRepository(Pessoa::class)->find($ids['pessoa_id']);

        $this->assertEmpty($pedido_after);
        $this->assertEmpty($produto_after);
        $this->assertEmpty($pessoa_after);
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->em->close();
        $this->em = null; // avoid memory leaks
    }
}
