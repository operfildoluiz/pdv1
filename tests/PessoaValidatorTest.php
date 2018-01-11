<?php

namespace App\Tests;

use App\Model\Validators\PessoaValidator;
use PHPUnit\Framework\TestCase;

class PessoaValidatorTest extends TestCase
{

    public function testMissingNome()
    {

        $objetoPessoa = new PessoaValidator();
        $objetoPessoa->setDataNascimento('00/00/0000');
        $errors = $objetoPessoa->validate();

        $this->assertCount(1, $errors);
    }

    public function testMissingDataNascimento()
    {

        $objetoPessoa = new PessoaValidator();
        $objetoPessoa->setNome('Any');
        $errors = $objetoPessoa->validate();

        $this->assertCount(1, $errors);
    }

    public function testMissingId()
    {

        $objetoPessoa = new PessoaValidator();
        $objetoPessoa->setNome('Any');
        $objetoPessoa->setDataNascimento('00/00/0000');
        $errors = $objetoPessoa->validate(true);

        $this->assertCount(1, $errors);
    }

    public function testShouldCreate()
    {

        $objetoPessoa = new PessoaValidator();
        $objetoPessoa->setNome('Any');
        $objetoPessoa->setDataNascimento('00/00/0000');
        $errors = $objetoPessoa->validate();

        $this->assertFalse($errors);
    }

    public function testShouldUpdate()
    {

        $objetoPessoa = new PessoaValidator();
        $objetoPessoa->setId('Any');
        $objetoPessoa->setNome('Any');
        $objetoPessoa->setDataNascimento('00/00/0000');
        $errors = $objetoPessoa->validate(true);

        $this->assertFalse($errors);
    }

}
