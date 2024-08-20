<?php

class Status extends TRecord
{
    const TABLENAME  = 'status';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nome');
        parent::addAttribute('cor');
        parent::addAttribute('estado_inicial');
        parent::addAttribute('estado_final');
        parent::addAttribute('ativo');
            
    }

    /**
     * Method getChamados
     */
    public function getChamados()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('status_id', '=', $this->id));
        return Chamado::getObjects( $criteria );
    }

    public function set_chamado_solicitante_to_string($chamado_solicitante_to_string)
    {
        if(is_array($chamado_solicitante_to_string))
        {
            $values = Cliente::where('id', 'in', $chamado_solicitante_to_string)->getIndexedArray('id', 'id');
            $this->chamado_solicitante_to_string = implode(', ', $values);
        }
        else
        {
            $this->chamado_solicitante_to_string = $chamado_solicitante_to_string;
        }

        $this->vdata['chamado_solicitante_to_string'] = $this->chamado_solicitante_to_string;
    }

    public function get_chamado_solicitante_to_string()
    {
        if(!empty($this->chamado_solicitante_to_string))
        {
            return $this->chamado_solicitante_to_string;
        }
    
        $values = Chamado::where('status_id', '=', $this->id)->getIndexedArray('solicitante_id','{solicitante->id}');
        return implode(', ', $values);
    }

    public function set_chamado_status_to_string($chamado_status_to_string)
    {
        if(is_array($chamado_status_to_string))
        {
            $values = Status::where('id', 'in', $chamado_status_to_string)->getIndexedArray('nome', 'nome');
            $this->chamado_status_to_string = implode(', ', $values);
        }
        else
        {
            $this->chamado_status_to_string = $chamado_status_to_string;
        }

        $this->vdata['chamado_status_to_string'] = $this->chamado_status_to_string;
    }

    public function get_chamado_status_to_string()
    {
        if(!empty($this->chamado_status_to_string))
        {
            return $this->chamado_status_to_string;
        }
    
        $values = Chamado::where('status_id', '=', $this->id)->getIndexedArray('status_id','{status->nome}');
        return implode(', ', $values);
    }

    public function set_chamado_prioridade_to_string($chamado_prioridade_to_string)
    {
        if(is_array($chamado_prioridade_to_string))
        {
            $values = Prioridade::where('id', 'in', $chamado_prioridade_to_string)->getIndexedArray('nome', 'nome');
            $this->chamado_prioridade_to_string = implode(', ', $values);
        }
        else
        {
            $this->chamado_prioridade_to_string = $chamado_prioridade_to_string;
        }

        $this->vdata['chamado_prioridade_to_string'] = $this->chamado_prioridade_to_string;
    }

    public function get_chamado_prioridade_to_string()
    {
        if(!empty($this->chamado_prioridade_to_string))
        {
            return $this->chamado_prioridade_to_string;
        }
    
        $values = Chamado::where('status_id', '=', $this->id)->getIndexedArray('prioridade_id','{prioridade->nome}');
        return implode(', ', $values);
    }

    public function set_chamado_produto_to_string($chamado_produto_to_string)
    {
        if(is_array($chamado_produto_to_string))
        {
            $values = Produto::where('id', 'in', $chamado_produto_to_string)->getIndexedArray('nome', 'nome');
            $this->chamado_produto_to_string = implode(', ', $values);
        }
        else
        {
            $this->chamado_produto_to_string = $chamado_produto_to_string;
        }

        $this->vdata['chamado_produto_to_string'] = $this->chamado_produto_to_string;
    }

    public function get_chamado_produto_to_string()
    {
        if(!empty($this->chamado_produto_to_string))
        {
            return $this->chamado_produto_to_string;
        }
    
        $values = Chamado::where('status_id', '=', $this->id)->getIndexedArray('produto_id','{produto->nome}');
        return implode(', ', $values);
    }

    public function set_chamado_categoria_to_string($chamado_categoria_to_string)
    {
        if(is_array($chamado_categoria_to_string))
        {
            $values = Categoria::where('id', 'in', $chamado_categoria_to_string)->getIndexedArray('nome', 'nome');
            $this->chamado_categoria_to_string = implode(', ', $values);
        }
        else
        {
            $this->chamado_categoria_to_string = $chamado_categoria_to_string;
        }

        $this->vdata['chamado_categoria_to_string'] = $this->chamado_categoria_to_string;
    }

    public function get_chamado_categoria_to_string()
    {
        if(!empty($this->chamado_categoria_to_string))
        {
            return $this->chamado_categoria_to_string;
        }
    
        $values = Chamado::where('status_id', '=', $this->id)->getIndexedArray('categoria_id','{categoria->nome}');
        return implode(', ', $values);
    }

    public function set_chamado_atendente_to_string($chamado_atendente_to_string)
    {
        if(is_array($chamado_atendente_to_string))
        {
            $values = Atendente::where('id', 'in', $chamado_atendente_to_string)->getIndexedArray('id', 'id');
            $this->chamado_atendente_to_string = implode(', ', $values);
        }
        else
        {
            $this->chamado_atendente_to_string = $chamado_atendente_to_string;
        }

        $this->vdata['chamado_atendente_to_string'] = $this->chamado_atendente_to_string;
    }

    public function get_chamado_atendente_to_string()
    {
        if(!empty($this->chamado_atendente_to_string))
        {
            return $this->chamado_atendente_to_string;
        }
    
        $values = Chamado::where('status_id', '=', $this->id)->getIndexedArray('atendente_id','{atendente->id}');
        return implode(', ', $values);
    }

    public function set_chamado_tipo_problema_to_string($chamado_tipo_problema_to_string)
    {
        if(is_array($chamado_tipo_problema_to_string))
        {
            $values = TipoProblema::where('id', 'in', $chamado_tipo_problema_to_string)->getIndexedArray('nome', 'nome');
            $this->chamado_tipo_problema_to_string = implode(', ', $values);
        }
        else
        {
            $this->chamado_tipo_problema_to_string = $chamado_tipo_problema_to_string;
        }

        $this->vdata['chamado_tipo_problema_to_string'] = $this->chamado_tipo_problema_to_string;
    }

    public function get_chamado_tipo_problema_to_string()
    {
        if(!empty($this->chamado_tipo_problema_to_string))
        {
            return $this->chamado_tipo_problema_to_string;
        }
    
        $values = Chamado::where('status_id', '=', $this->id)->getIndexedArray('tipo_problema_id','{tipo_problema->nome}');
        return implode(', ', $values);
    }

    public function set_chamado_tipo_solucao_to_string($chamado_tipo_solucao_to_string)
    {
        if(is_array($chamado_tipo_solucao_to_string))
        {
            $values = TipoSolucao::where('id', 'in', $chamado_tipo_solucao_to_string)->getIndexedArray('nome', 'nome');
            $this->chamado_tipo_solucao_to_string = implode(', ', $values);
        }
        else
        {
            $this->chamado_tipo_solucao_to_string = $chamado_tipo_solucao_to_string;
        }

        $this->vdata['chamado_tipo_solucao_to_string'] = $this->chamado_tipo_solucao_to_string;
    }

    public function get_chamado_tipo_solucao_to_string()
    {
        if(!empty($this->chamado_tipo_solucao_to_string))
        {
            return $this->chamado_tipo_solucao_to_string;
        }
    
        $values = Chamado::where('status_id', '=', $this->id)->getIndexedArray('tipo_solucao_id','{tipo_solucao->nome}');
        return implode(', ', $values);
    }

    
}

