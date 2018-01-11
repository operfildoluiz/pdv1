<?php

namespace App\Tests;

use App\Entity\Pessoa;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PessoaTest extends KernelTestCase
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

        $pessoa = new Pessoa();
        $pessoa->setNome('Test ' . $temp_name);
        $pessoa->setDataNascimento(new \DateTime('now'));

        $this->em->persist($pessoa);
        $this->em->flush();

        $this->assertNotEmpty($pessoa->getId());

        $this->temp_id = $pessoa->getId();

        return $this->temp_id;
    }

    /**
     * @depends testCreate
     */
    public function testRemove($temp_id)
    {
        $this->temp_id = $temp_id;

        $pessoa = $this->em->getRepository(Pessoa::class)->find($this->temp_id);
        $this->em->remove($pessoa);
        $this->em->flush();

        $pessoa_after = $this->em->getRepository(Pessoa::class)->find($this->temp_id);

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
