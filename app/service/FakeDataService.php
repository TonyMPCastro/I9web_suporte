<?php

class FakeDataService
{
    public static function generateChamados()
    {
        $produtos = Produto::getObjects();
        $categorias = Categoria::getObjects();
        $prioridades = Prioridade::getObjects();
        $tipos_solucoes = TipoSolucao::getObjects();
        $tipos_problemas = TipoProblema::getObjects();
        $status = Status::getObjects();
        
        for($i = 0; $i <= 2000; $i++)
        {
            $data1 = '2022-' .  str_pad(rand(1,12), 2, "0", STR_PAD_LEFT) . '-' . str_pad(rand(1,28), 2, "0", STR_PAD_LEFT) . ' ' . str_pad(rand(0,23), 2, "0", STR_PAD_LEFT) . ':' . str_pad(rand(0,59), 2, "0", STR_PAD_LEFT);
            $data2 = '2022-' .  str_pad(rand(1,12), 2, "0", STR_PAD_LEFT) . '-' . str_pad(rand(1,28), 2, "0", STR_PAD_LEFT) . ' ' . str_pad(rand(0,23), 2, "0", STR_PAD_LEFT) . ':' . str_pad(rand(0,59), 2, "0", STR_PAD_LEFT);
            
            $data_ini = $data2 < $data1 ? $data2 : $data1;
            $data_fim = $data2 < $data1 ? $data1 : $data2;
            
            $chamado = new Chamado();
            $chamado->solicitante_id = rand(1,2);
            $chamado->produto_id = rand(1, count($produtos));
            $chamado->categoria_id = rand(1, count($categorias));
            $chamado->status_id = rand(1, count($status));
            $chamado->prioridade_id = rand(1, count($prioridades));
            $chamado->dt_abertura = $data_ini;
            $chamado->mes_abertura = date('m', strtotime($data_ini));
            $chamado->ano_abertura = date('Y', strtotime($data_ini));
            $chamado->anomes_abertura = date('Ym', strtotime($data_ini));
            $chamado->atendente_id = 1;
            $chamado->tipo_problema_id = rand(1, count($tipos_problemas));
            $chamado->observacao_abertura = 'Observação abertura: ' . $chamado->tipo_problema->nome;
            $chamado->recorente = rand(0,1);
            
            if ($chamado->status->estado_final == 'T')
            {
                $chamado->tipo_solucao_id = rand(1, count($tipos_solucoes));
                $chamado->dt_fechamento = $data_fim;
                $chamado->mes_fechamento = date('m', strtotime($data_fim));
                $chamado->ano_fechamento = date('Y', strtotime($data_fim));
                $chamado->anomes_fechamento = date('Ym', strtotime($data_fim));
                $chamado->observacao_finalizacao = 'Observação finalizacao: ' . $chamado->tipo_solucao->nome;
                $chamado->tempo_trabalho = str_pad(rand(0,23), 2, "0", STR_PAD_LEFT) . ':' . str_pad(rand(0,59), 2, "0", STR_PAD_LEFT);
            }
            
            $chamado->store();
        }
    }
}
