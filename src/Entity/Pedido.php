<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PedidoRepository")
 */
class Pedido implements \JsonSerializable
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
     * @ORM\Column(name="numero", type="integer", nullable=true)
     */
    protected $numero;

    /**
     * @ORM\Column(type="date", name="emissao", nullable=false)
     */
    protected $emissao;

    /**
     * @ORM\Column(type="decimal", name="total", nullable=false, scale=2, precision=10)
     */
    protected $total;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Pessoa", inversedBy="pedidos")
     * @ORM\JoinColumn(nullable=true)
     */
    private $cliente;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ItemPedido", mappedBy="pedido")
     */
    private $pedidos;

    public function __construct()
    {
        $this->pedidos = new ArrayCollection();
    }

    /**
     * @return Collection|ItemPedido[]
     */
    public function getItemPedidos()
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

    public function getCliente(): Pessoa
    {
        return $this->cliente;
    }

    public function setCliente(Pessoa $cliente)
    {
        $this->cliente = $cliente;
    }

    /**
     * @return mixed
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param mixed $numero
     *
     * @return self
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmissao()
    {
        return $this->emissao;
    }

    /**
     * @param mixed $emissao
     *
     * @return self
     */
    public function setEmissao($emissao)
    {
        $this->emissao = $emissao;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param mixed $total
     *
     * @return self
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }
}
