<?php

namespace App\Model\Validators;

class ProdutoValidator {

    private $id;
    private $nome;
    private $codigo;
    private $precoUnitario;

    public function validate($update = false) {

        $errors = array();

        if (empty($this->getNome()))
            $errors[] = "Nome não deve ficar em branco";

        if (empty($this->getCodigo()))
            $errors[] = "Código do produto não deve ficar em branco";

        if (empty($this->getPrecoUnitario()))
            $errors[] = "O preço unitário não deve ficar em branco";
        elseif($this->getPrecoUnitario() <= 0)
            $errors[] = "O preço unitário deve ser superior a zero";

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
        if (!empty($precoUnitario))
            $precoUnitario = str_replace(",", ".", $precoUnitario);

        $this->precoUnitario = $precoUnitario;

        return $this;
    }
}
