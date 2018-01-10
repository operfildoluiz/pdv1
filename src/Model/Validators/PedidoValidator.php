<?php

namespace App\Model\Validators;

class PedidoValidator {

    private $cliente_id;
    private $total;
    private $items;

    public function validate() {

        $errors = array();

        if (empty($this->getClienteId()))
            $errors[] = "ID do Cliente não deve ficar em branco";

        if (empty($this->getItems()) || count($this->getItems()) == 0)
            $errors[] = "Lista de itens não deve ficar em branco";

        if (empty($this->getTotal()))
            $errors[] = "O total não deve ficar em branco";
        elseif($this->getTotal() <= 0)
            $errors[] = "O total deve ser superior a zero";

        if (count($errors) > 0)
            return $errors;

        return false;

    }



    /**
     * @return mixed
     */
    public function getClienteId()
    {
        return $this->cliente_id;
    }

    /**
     * @param mixed $cliente_id
     *
     * @return self
     */
    public function setClienteId($cliente_id)
    {
        $this->cliente_id = $cliente_id;

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

    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param mixed $items
     *
     * @return self
     */
    public function setItems($items)
    {
        $this->items = $items;

        return $this;
    }
}
