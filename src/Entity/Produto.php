<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProdutoRepository")
 */
class Produto implements \JsonSerializable
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
     * @ORM\Column(type="string", name="codigo", length=255, unique=true, nullable=false)
     * @Assert\NotBlank(message="Codigo não pode ficar em branco")
     */
    protected $codigo;

    /**
     * @ORM\Column(type="string", name="nome", length=255, unique=true, nullable=false)
     * @Assert\NotBlank(message="Nome não pode ficar em branco")
     */
    protected $nome;

    /**
     * @ORM\Column(type="decimal", name="precoUnitario", nullable=false, scale=2, precision=10)
     * @Assert\NotBlank(message="Preço não pode ficar em branco")
     */
    protected $precoUnitario;


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
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param mixed $codigo
     *
     * @return self
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
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
    public function getPrecoUnitario()
    {
        return $this->precoUnitario;
    }

    /**
     * @param mixed $precoUnitario
     *
     * @return self
     */
    public function setPrecoUnitario($precoUnitario)
    {
        $this->precoUnitario = $precoUnitario;

        return $this;
    }
}
