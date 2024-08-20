<?php

class DadosController extends TPage
{
    public function __construct($param)
    {
        parent::__construct();
    }
    
    // função executa ao clicar no item de menu
    public function onShow($param = null)
    {
        try
        {
            TTransaction::open('chamado');
            FakeDataService::generateChamados();
            TTransaction::close();

            new TMessage('info', 'Dados fakes gerados');
        }
        catch (Exception $e)
        {
            TTransaction::rollback();
            new TMessage('error', $e->getMessage());
        }
    }
}
