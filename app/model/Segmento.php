<?php

class Segmento extends TRecord
{
    const TABLENAME  = 'segmento';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nome');
            
    }

    /**
     * Method getClientes
     */
    public function getClientes()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('segmento_id', '=', $this->id));
        return Cliente::getObjects( $criteria );
    }

    public function set_cliente_segmento_to_string($cliente_segmento_to_string)
    {
        if(is_array($cliente_segmento_to_string))
        {
            $values = Segmento::where('id', 'in', $cliente_segmento_to_string)->getIndexedArray('nome', 'nome');
            $this->cliente_segmento_to_string = implode(', ', $values);
        }
        else
        {
            $this->cliente_segmento_to_string = $cliente_segmento_to_string;
        }

        $this->vdata['cliente_segmento_to_string'] = $this->cliente_segmento_to_string;
    }

    public function get_cliente_segmento_to_string()
    {
        if(!empty($this->cliente_segmento_to_string))
        {
            return $this->cliente_segmento_to_string;
        }
    
        $values = Cliente::where('segmento_id', '=', $this->id)->getIndexedArray('segmento_id','{segmento->nome}');
        return implode(', ', $values);
    }

    
}

