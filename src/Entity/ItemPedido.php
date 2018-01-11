<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ItemPedidoRepository")
 */
class ItemPedido
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Produto", inversedBy="item_pedidos")
     * @ORM\JoinColumn(nullable=true)
     */
    private $produto;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Pedido", inversedBy="item_pedidos")
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id", onDelete="CASCADE")
     */
    private $pedido;

    /**
     * @ORM\Column(type="decimal", name="quantidade", nullable=false, scale=2, precision=10)
     */
    protected $quantidade;

    /**
     * @ORM\Column(type="decimal", name="precoUnitario", nullable=false, scale=2, precision=10)
     */
    protected $precoUnitario;

    /**
     * @ORM\Column(type="decimal", name="percentualDesconto", nullable=false, scale=2, precision=10)
     */
    protected $percentualDesconto;

    /**
     * @ORM\Column(type="decimal", name="total", nullable=false, scale=2, precision=10)
     */
    protected $total;

    /**
     * @return \Ramsey\Uuid\Uuid
     */
    public function getId()
    {
        return $this->id;
    }

    public function getProduto(): Produto
    {
        return $this->produto;
    }

    public function setProduto(Produto $produto)
    {
        $this->produto = $produto;
    }

    public function getPedido(): Pedido
    {
        return $this->pedido;
    }

    public function setPedido(Pedido $pedido)
    {
        $this->pedido = $pedido;
    }

    /**
     * @return mixed
     */
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    /**
     * @param mixed $quantidade
     *
     * @return self
     */
    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;

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

    /**
     * @return mixed
     */
    public function getPercentualDesconto()
    {
        return $this->percentualDesconto;
    }

    /**
     * @param mixed $percentualDesconto
     *
     * @return self
     */
    public function setPercentualDesconto($percentualDesconto)
    {
        $this->percentualDesconto = $percentualDesconto;

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
