<?php

namespace App\Tests;

use App\Model\Validators\ProdutoValidator;
use PHPUnit\Framework\TestCase;

class ProdutoValidatorTest extends TestCase
{

    public function testMissingNome()
    {

        $objetoProduto = new ProdutoValidator();
        $objetoProduto->setCodigo('Any');
        $objetoProduto->setPrecoUnitario('1');
        $errors = $objetoProduto->validate();

        $this->assertCount(1, $errors);
    }

    public function testMissingCodigo()
    {

        $objetoProduto = new ProdutoValidator();
        $objetoProduto->setNome('Any');
        $objetoProduto->setPrecoUnitario('1');
        $errors = $objetoProduto->validate();

        $this->assertCount(1, $errors);
    }

    public function testMissingPreco()
    {

        $objetoProduto = new ProdutoValidator();
        $objetoProduto->setNome('Any');
        $objetoProduto->setCodigo('Any');
        $errors = $objetoProduto->validate();

        $this->assertCount(1, $errors);
    }

    public function testWrongPreco()
    {

        $objetoProduto = new ProdutoValidator();
        $objetoProduto->setNome('Any');
        $objetoProduto->setCodigo('Any');
        $objetoProduto->setPrecoUnitario('0');
        $errors = $objetoProduto->validate();

        $this->assertCount(1, $errors);
    }

    public function testMissingId()
    {

        $objetoProduto = new ProdutoValidator();
        $objetoProduto->setNome('Any');
        $objetoProduto->setCodigo('Any');
        $objetoProduto->setPrecoUnitario('1');
        $errors = $objetoProduto->validate(true);

        $this->assertCount(1, $errors);
    }

    public function testShouldCreate()
    {

        $objetoProduto = new ProdutoValidator();
        $objetoProduto->setNome('Any');
        $objetoProduto->setCodigo('Any');
        $objetoProduto->setPrecoUnitario('1');
        $errors = $objetoProduto->validate();

        $this->assertFalse($errors);
    }

    public function testShouldUpdate()
    {

        $objetoProduto = new ProdutoValidator();
        $objetoProduto->setId('Any');
        $objetoProduto->setNome('Any');
        $objetoProduto->setCodigo('Any');
        $objetoProduto->setPrecoUnitario('1');
        $errors = $objetoProduto->validate(true);

        $this->assertFalse($errors);
    }

}
