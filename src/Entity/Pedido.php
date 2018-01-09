<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PedidoRepository")
 */
class Pedido
{
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
     * @ORM\Column(type="integer", name="numero", unique=true, nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
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
