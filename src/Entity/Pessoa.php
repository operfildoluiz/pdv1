<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PessoaRepository")
 */
class Pessoa implements \JsonSerializable
{
    public function jsonSerialize() {
        return (object) get_object_vars($this);
    }

    /**
     * @var \Ramsey\Uuid\Uuid
     *
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    protected $id;


    /**
     * @ORM\Column(type="string", name="nome", length=255, unique=true, nullable=false)
     * @Assert\NotBlank(message="Nome não pode ficar em branco")
     */
    protected $nome;

    /**
     * @ORM\Column(type="date", name="dataNascimento", nullable=false)
     * @Assert\NotBlank(message="Data Nascimento não pode ficar em branco")
     * @Assert\Date(message="Insira uma data válida")
     */
    protected $dataNascimento;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Pedido", mappedBy="pessoa")
     */
    private $pedidos;

    public function __construct()
    {
        $this->pedidos = new ArrayCollection();
    }

    /**
     * @return Collection|Pedido[]
     */
    public function getPedidos()
    {
        return $this->pedidos;
    }

    /**
     * @return \Ramsey\Uuid\Uuid
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     *
     * @return self
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDataNascimento()
    {
        return $this->dataNascimento;
    }

    /**
     * @param mixed $dataNascimento
     *
     * @return self
     */
    public function setDataNascimento($dataNascimento)
    {
        $this->dataNascimento = $dataNascimento;

        return $this;
    }
}
