<?php

class Chamado extends TRecord
{
    const TABLENAME  = 'chamado';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const CREATEDAT  = 'dt_abertura';

    private $solicitante;
    private $atendente;
    private $status;
    private $tipo_problema;
    private $tipo_solucao;
    private $produto;
    private $categoria;
    private $prioridade;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('solicitante_id');
        parent::addAttribute('status_id');
        parent::addAttribute('prioridade_id');
        parent::addAttribute('produto_id');
        parent::addAttribute('categoria_id');
        parent::addAttribute('dt_abertura');
        parent::addAttribute('observacao_abertura');
        parent::addAttribute('atendente_id');
        parent::addAttribute('tipo_problema_id');
        parent::addAttribute('tipo_solucao_id');
        parent::addAttribute('dt_fechamento');
        parent::addAttribute('observacao_finalizacao');
        parent::addAttribute('tempo_trabalho');
        parent::addAttribute('recorente');
        parent::addAttribute('mes_abertura');
        parent::addAttribute('ano_abertura');
        parent::addAttribute('anomes_abertura');
        parent::addAttribute('ano_fechamento');
        parent::addAttribute('mes_fechamento');
        parent::addAttribute('anomes_fechamento');
    
    }

    /**
     * Method set_cliente
     * Sample of usage: $var->cliente = $object;
     * @param $object Instance of Cliente
     */
    public function set_solicitante(Cliente $object)
    {
        $this->solicitante = $object;
        $this->solicitante_id = $object->id;
    }

    /**
     * Method get_solicitante
     * Sample of usage: $var->solicitante->attribute;
     * @returns Cliente instance
     */
    public function get_solicitante()
    {
    
        // loads the associated object
        if (empty($this->solicitante))
            $this->solicitante = new Cliente($this->solicitante_id);
    
        // returns the associated object
        return $this->solicitante;
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
    /**
     * Method set_status
     * Sample of usage: $var->status = $object;
     * @param $object Instance of Status
     */
    public function set_status(Status $object)
    {
        $this->status = $object;
        $this->status_id = $object->id;
    }

    /**
     * Method get_status
     * Sample of usage: $var->status->attribute;
     * @returns Status instance
     */
    public function get_status()
    {
    
        // loads the associated object
        if (empty($this->status))
            $this->status = new Status($this->status_id);
    
        // returns the associated object
        return $this->status;
    }
    /**
     * Method set_tipo_problema
     * Sample of usage: $var->tipo_problema = $object;
     * @param $object Instance of TipoProblema
     */
    public function set_tipo_problema(TipoProblema $object)
    {
        $this->tipo_problema = $object;
        $this->tipo_problema_id = $object->id;
    }

    /**
     * Method get_tipo_problema
     * Sample of usage: $var->tipo_problema->attribute;
     * @returns TipoProblema instance
     */
    public function get_tipo_problema()
    {
    
        // loads the associated object
        if (empty($this->tipo_problema))
            $this->tipo_problema = new TipoProblema($this->tipo_problema_id);
    
        // returns the associated object
        return $this->tipo_problema;
    }
    /**
     * Method set_tipo_solucao
     * Sample of usage: $var->tipo_solucao = $object;
     * @param $object Instance of TipoSolucao
     */
    public function set_tipo_solucao(TipoSolucao $object)
    {
        $this->tipo_solucao = $object;
        $this->tipo_solucao_id = $object->id;
    }

    /**
     * Method get_tipo_solucao
     * Sample of usage: $var->tipo_solucao->attribute;
     * @returns TipoSolucao instance
     */
    public function get_tipo_solucao()
    {
    
        // loads the associated object
        if (empty($this->tipo_solucao))
            $this->tipo_solucao = new TipoSolucao($this->tipo_solucao_id);
    
        // returns the associated object
        return $this->tipo_solucao;
    }
    /**
     * Method set_produto
     * Sample of usage: $var->produto = $object;
     * @param $object Instance of Produto
     */
    public function set_produto(Produto $object)
    {
        $this->produto = $object;
        $this->produto_id = $object->id;
    }

    /**
     * Method get_produto
     * Sample of usage: $var->produto->attribute;
     * @returns Produto instance
     */
    public function get_produto()
    {
    
        // loads the associated object
        if (empty($this->produto))
            $this->produto = new Produto($this->produto_id);
    
        // returns the associated object
        return $this->produto;
    }
    /**
     * Method set_categoria
     * Sample of usage: $var->categoria = $object;
     * @param $object Instance of Categoria
     */
    public function set_categoria(Categoria $object)
    {
        $this->categoria = $object;
        $this->categoria_id = $object->id;
    }

    /**
     * Method get_categoria
     * Sample of usage: $var->categoria->attribute;
     * @returns Categoria instance
     */
    public function get_categoria()
    {
    
        // loads the associated object
        if (empty($this->categoria))
            $this->categoria = new Categoria($this->categoria_id);
    
        // returns the associated object
        return $this->categoria;
    }
    /**
     * Method set_prioridade
     * Sample of usage: $var->prioridade = $object;
     * @param $object Instance of Prioridade
     */
    public function set_prioridade(Prioridade $object)
    {
        $this->prioridade = $object;
        $this->prioridade_id = $object->id;
    }

    /**
     * Method get_prioridade
     * Sample of usage: $var->prioridade->attribute;
     * @returns Prioridade instance
     */
    public function get_prioridade()
    {
    
        // loads the associated object
        if (empty($this->prioridade))
            $this->prioridade = new Prioridade($this->prioridade_id);
    
        // returns the associated object
        return $this->prioridade;
    }

    /**
     * Method getArquivoChamados
     */
    public function getArquivoChamados()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('chamado_id', '=', $this->id));
        return ArquivoChamado::getObjects( $criteria );
    }
    /**
     * Method getNotas
     */
    public function getNotas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('chamado_id', '=', $this->id));
        return Nota::getObjects( $criteria );
    }

    public function set_arquivo_chamado_chamado_to_string($arquivo_chamado_chamado_to_string)
    {
        if(is_array($arquivo_chamado_chamado_to_string))
        {
            $values = Chamado::where('id', 'in', $arquivo_chamado_chamado_to_string)->getIndexedArray('id', 'id');
            $this->arquivo_chamado_chamado_to_string = implode(', ', $values);
        }
        else
        {
            $this->arquivo_chamado_chamado_to_string = $arquivo_chamado_chamado_to_string;
        }

        $this->vdata['arquivo_chamado_chamado_to_string'] = $this->arquivo_chamado_chamado_to_string;
    }

    public function get_arquivo_chamado_chamado_to_string()
    {
        if(!empty($this->arquivo_chamado_chamado_to_string))
        {
            return $this->arquivo_chamado_chamado_to_string;
        }
    
        $values = ArquivoChamado::where('chamado_id', '=', $this->id)->getIndexedArray('chamado_id','{chamado->id}');
        return implode(', ', $values);
    }

    public function set_nota_chamado_to_string($nota_chamado_to_string)
    {
        if(is_array($nota_chamado_to_string))
        {
            $values = Chamado::where('id', 'in', $nota_chamado_to_string)->getIndexedArray('id', 'id');
            $this->nota_chamado_to_string = implode(', ', $values);
        }
        else
        {
            $this->nota_chamado_to_string = $nota_chamado_to_string;
        }

        $this->vdata['nota_chamado_to_string'] = $this->nota_chamado_to_string;
    }

    public function get_nota_chamado_to_string()
    {
        if(!empty($this->nota_chamado_to_string))
        {
            return $this->nota_chamado_to_string;
        }
    
        $values = Nota::where('chamado_id', '=', $this->id)->getIndexedArray('chamado_id','{chamado->id}');
        return implode(', ', $values);
    }

    public function set_nota_cliente_to_string($nota_cliente_to_string)
    {
        if(is_array($nota_cliente_to_string))
        {
            $values = Cliente::where('id', 'in', $nota_cliente_to_string)->getIndexedArray('id', 'id');
            $this->nota_cliente_to_string = implode(', ', $values);
        }
        else
        {
            $this->nota_cliente_to_string = $nota_cliente_to_string;
        }

        $this->vdata['nota_cliente_to_string'] = $this->nota_cliente_to_string;
    }

    public function get_nota_cliente_to_string()
    {
        if(!empty($this->nota_cliente_to_string))
        {
            return $this->nota_cliente_to_string;
        }
    
        $values = Nota::where('chamado_id', '=', $this->id)->getIndexedArray('cliente_id','{cliente->id}');
        return implode(', ', $values);
    }

    public function set_nota_atendente_to_string($nota_atendente_to_string)
    {
        if(is_array($nota_atendente_to_string))
        {
            $values = Atendente::where('id', 'in', $nota_atendente_to_string)->getIndexedArray('id', 'id');
            $this->nota_atendente_to_string = implode(', ', $values);
        }
        else
        {
            $this->nota_atendente_to_string = $nota_atendente_to_string;
        }

        $this->vdata['nota_atendente_to_string'] = $this->nota_atendente_to_string;
    }

    public function get_nota_atendente_to_string()
    {
        if(!empty($this->nota_atendente_to_string))
        {
            return $this->nota_atendente_to_string;
        }
    
        $values = Nota::where('chamado_id', '=', $this->id)->getIndexedArray('atendente_id','{atendente->id}');
        return implode(', ', $values);
    }

    public function get_dt_abertura_formatada()
    {
        if ($this->dt_abertura)
        {
            return date('d/m/Y H:i', strtotime($this->dt_abertura));
        }
    
        return '';
    }

    public function get_dt_fechamento_formatada()
    {
        if ($this->dt_fechamento)
        {
            return date('d/m/Y H:i', strtotime($this->dt_fechamento));
        }
        
        return '';
    }
    
}

