<?php

namespace App\Tests;

use App\Model\Validators\PedidoValidator;
use PHPUnit\Framework\TestCase;

class PedidoValidatorTest extends TestCase
{

    public function testMissingCliente()
    {

        $objetoPedido = new PedidoValidator();
        $objetoPedido->setItems(['Item']);
        $objetoPedido->setTotal('1.00');
        $errors = $objetoPedido->validate();

        $this->assertCount(1, $errors);
    }

    public function testMissingTotal()
    {

        $objetoPedido = new PedidoValidator();
        $objetoPedido->setClienteId('Any');
        $objetoPedido->setItems(['Item']);
        $errors = $objetoPedido->validate();

        $this->assertCount(1, $errors);
    }

    public function testWrongTotal()
    {

        $objetoPedido = new PedidoValidator();
        $objetoPedido->setClienteId('Any');
        $objetoPedido->setItems(['Item']);
        $objetoPedido->setTotal('0');
        $errors = $objetoPedido->validate();

        $this->assertCount(1, $errors);
    }

    public function testMissingItem()
    {

        $objetoPedido = new PedidoValidator();
        $objetoPedido->setClienteId('Any');
        $objetoPedido->setTotal('1');
        $errors = $objetoPedido->validate();

        $this->assertCount(1, $errors);
    }

    public function testWrongItem()
    {

        $objetoPedido = new PedidoValidator();
        $objetoPedido->setClienteId('Any');
        $objetoPedido->setItems([]);
        $objetoPedido->setTotal('1');
        $errors = $objetoPedido->validate();

        $this->assertCount(1, $errors);
    }

    public function testShouldCreate()
    {

        $objetoPedido = new PedidoValidator();
        $objetoPedido->setClienteId('Any');
        $objetoPedido->setItems(['Item']);
        $objetoPedido->setTotal('1');
        $errors = $objetoPedido->validate();

        $this->assertFalse($errors);
    }


}
