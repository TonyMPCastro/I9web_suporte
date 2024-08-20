<?php

class Nota extends TRecord
{
    const TABLENAME  = 'nota';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const CREATEDAT  = 'dt_nota';

    private $chamado;
    private $cliente;
    private $atendente;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('observacao');
        parent::addAttribute('dt_nota');
        parent::addAttribute('chamado_id');
        parent::addAttribute('cliente_id');
        parent::addAttribute('atendente_id');
        parent::addAttribute('anexo');
            
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
    /**
     * Method set_cliente
     * Sample of usage: $var->cliente = $object;
     * @param $object Instance of Cliente
     */
    public function set_cliente(Cliente $object)
    {
        $this->cliente = $object;
        $this->cliente_id = $object->id;
    }

    /**
     * Method get_cliente
     * Sample of usage: $var->cliente->attribute;
     * @returns Cliente instance
     */
    public function get_cliente()
    {
    
        // loads the associated object
        if (empty($this->cliente))
            $this->cliente = new Cliente($this->cliente_id);
    
        // returns the associated object
        return $this->cliente;
    }
    /**
     * Method set_atendente
     * Sample of usage: $var->atendente = $object;
     * @param $object Instance of Atendente
     */
    public function set_atendente(Atendente $object)
    {
        $this->atendente = $object;
        $this->atendente_id = $object->id;
    }

    /**
     * Method get_atendente
     * Sample of usage: $var->atendente->attribute;
     * @returns Atendente instance
     */
    public function get_atendente()
    {
    
        // loads the associated object
        if (empty($this->atendente))
            $this->atendente = new Atendente($this->atendente_id);
    
        // returns the associated object
        return $this->atendente;
    }

    
}

