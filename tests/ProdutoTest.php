<?php

namespace App\Tests;

use App\Entity\Produto;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProdutoTest extends KernelTestCase
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

        $this->temp_id = null;
    }

    public function testCreate()
    {

        $temp_name = substr(md5(mt_rand()), 0, 7);
        $temp_code= substr(md5(mt_rand()), 0, 4);

        $produto = new Produto();
        $produto->setNome('Test ' . $temp_name);
        $produto->setCodigo('TST' . $temp_code);
        $produto->setPrecoUnitario('8.88');

        $this->em->persist($produto);
        $this->em->flush();

        $this->assertNotEmpty($produto->getId());

        $this->temp_id = $produto->getId();

        return $this->temp_id;
    }

    /**
     * @depends testCreate
     */
    public function testRemove($temp_id)
    {
        $this->temp_id = $temp_id;

        $produto = $this->em->getRepository(Produto::class)->find($this->temp_id);
        $this->em->remove($produto);
        $this->em->flush();

        $produto_after = $this->em->getRepository(Produto::class)->find($this->temp_id);

        $this->assertEmpty($produto_after);
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
