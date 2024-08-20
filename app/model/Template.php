<?php

class Template extends TRecord
{
    const TABLENAME  = 'template';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    const EMAIL_ABERTURA_CHAMADO = '1';
    const EMAIL_FECHAMENTO_CHAMADO = '2';
    const NOTIFICACAO_NOVA_NOTA = '3';
    const EMAIL_NOVA_NOTA = '4';

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('chave');
        parent::addAttribute('template');
        parent::addAttribute('titulo');
    
    }

    public function parserTitulo($chamado, $nota = null)
    {
        return $this->replace($chamado, $nota, $this->titulo);
    }

    public function parserTemplate($chamado, $nota = null)
    {
        return $this->replace($chamado, $nota, $this->template);
    }

    public function replace($chamado, $nota, $content)
    {
        $content = str_replace('{$id}', $chamado->id, $content);
        $content = str_replace('{$estado}', $chamado->status->nome, $content);
        $content = str_replace('{$observacao_finalizacao}', $chamado->observacao_finalizacao, $content);
        $content = str_replace('{$observacao_abertura}', $chamado->observacao_abertura, $content);
        $content = str_replace('{$solicitante}', $chamado->solicitante->system_user->name, $content);
        $content = str_replace('{$categoria_nome}', $chamado->categoria->nome, $content);
        $content = str_replace('{$atendente}', $chamado->atendente->system_user->name, $content);
        $content = str_replace('{$dt_abertura}', date('d/m/Y H:i', strtotime($chamado->dt_abertura)), $content);
        $content = str_replace('{$dt_fechamento}', date('d/m/Y H:i', strtotime($chamado->dt_fechamento)), $content);
        $content = str_replace('{$produto}', date('d/m/Y H:i', strtotime($chamado->produto->nome)), $content);
    
    
        if ($nota)
        {
            $content = str_replace('{$observacao_nota}', $nota->observacao, $content);
            $content = str_replace('{$dt_nota}', date('d/m/Y H:i', strtotime($nota->dt_nota)), $content);
        }
    
        return $content;
    }
    
}

