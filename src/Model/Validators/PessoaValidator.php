<?php

namespace App\Model\Validators;

class PessoaValidator {

    private $id;
    private $nome;
    private $dataNascimento;

    public function validate($update = false) {

        $errors = array();

        if (empty($this->getNome()))
            $errors[] = "Nome não deve ficar em branco";

        if (empty($this->getDataNascimento()))
            $errors[] = "Data de nascimento não deve ficar em branco";

        if ($update && empty($this->getId()))
            $errors[] = "O ID deve ser informado";


        if (count($errors) > 0)
            return $errors;

        return false;

    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

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
    public function getDataNascimento($toDate = false)
    {
        if($toDate) {
            return \DateTime::createFromFormat("Y-m-d", $this->getDataNascimento());
        }

        return $this->dataNascimento;
    }

    /**
     * @param mixed $dataNascimento
     *
     * @return self
     */
    public function setDataNascimento($dataNascimento)
    {
        if (!empty($dataNascimento)) {
            $dataNascimento = \DateTime::createFromFormat('d/m/Y', $dataNascimento)->format('Y-m-d');
            $this->dataNascimento = $dataNascimento;
        }
        return $this;

    }
}
