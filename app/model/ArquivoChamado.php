<?php

class ArquivoChamado extends TRecord
{
    const TABLENAME  = 'arquivo_chamado';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $chamado;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('name');
        parent::addAttribute('chamado_id');
            
    }

    /**
     * Method set_chamado
     * Sample of usage: $var->chamado = $object;
     * @param $object Instance of Chamado
     */
    public function set_chamado(Chamado $object)
    {
        $this->chamado = $object;
        $this->chamado_id = $object->id;
    }

    /**
     * Method get_chamado
     * Sample of usage: $var->chamado->attribute;
     * @returns Chamado instance
     */
    public function get_chamado()
    {
    
        // loads the associated object
        if (empty($this->chamado))
            $this->chamado = new Chamado($this->chamado_id);
    
        // returns the associated object
        return $this->chamado;
    }

    
}

