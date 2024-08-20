<?php

class ChamadoFormView extends TPage
{
    protected $form; // form
    private static $database = 'chamado';
    private static $activeRecord = 'Chamado';
    private static $primaryKey = 'id';
    private static $formName = 'formView_Chamado';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        TTransaction::open(self::$database);
        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        $this->form->setTagName('div');

        $chamado = new Chamado($param['key']);
        // define the form title
        $this->form->setFormTitle("Detalhe do chamado <b>#{$param['id']}</b>");

        $transformed_chamado_status_nome = call_user_func(function($value, $object, $row)
        {
            return "<div class='label' style='background: {$object->status->cor} ; width: 100%; color: white;'>{$value}</div>";

        }, $chamado->status->nome, $chamado, null);    

        $transformed_chamado_observacao_abertura = call_user_func(function($value, $object, $row)
        {
            if ($value) { 
                return nl2br($value);
            }

            return $value;
        }, $chamado->observacao_abertura, $chamado, null);    

        $transformed_chamado_observacao_finalizacao = call_user_func(function($value, $object, $row)
        {
            if ($value) { 
                return nl2br($value);
            }

            return $value;
        }, $chamado->observacao_finalizacao, $chamado, null);

        $label2111 = new TLabel("ID:", '', '14px', 'B', '100%');
        $text1211 = new TTextDisplay($chamado->id, '', '18px', '');
        $label10 = new TLabel("Situação:", '', '14px', 'B', '100%');
        $text5 = new TTextDisplay($transformed_chamado_status_nome, '', '18px', '');
        $label2 = new TLabel("Solicitante:", '', '14px', 'B', '100%');
        $text2 = new TTextDisplay($chamado->solicitante->id, '', '18px', '');
        $label62 = new TLabel("Abertura:", '', '14px', 'B', '100%');
        $text7 = new TTextDisplay(TDateTime::convertToMask($chamado->dt_abertura, 'yyyy-mm-dd hh:ii', 'dd/mm/yyyy hh:ii'), '', '18px', '');
        $label20 = new TLabel("Fechamento:", '', '14px', 'B', '100%');
        $text12 = new TTextDisplay(TDateTime::convertToMask($chamado->dt_fechamento, 'yyyy-mm-dd hh:ii', 'dd/mm/yyyy hh:ii'), '', '18px', '');
        $label41 = new TLabel("Produto:", '', '14px', 'B', '100%');
        $text3 = new TTextDisplay($chamado->produto->nome, '', '18px', '');
        $label81 = new TLabel("Categoria:", '', '14px', 'B', '100%');
        $text4 = new TTextDisplay($chamado->categoria->nome, '', '18px', '');
        $label12 = new TLabel("Prioridade:", '', '14px', 'B', '100%');
        $text6 = new TTextDisplay($chamado->prioridade->nome, '', '18px', '');
        $label141 = new TLabel("Atendente:", '', '14px', 'B', '100%');
        $text9 = new TTextDisplay($chamado->atendente->id, '', '18px', '');
        $label16 = new TLabel("Tipo do problema:", '', '14px', 'B', '100%');
        $text101 = new TTextDisplay($chamado->tipo_problema->nome, '', '18px', '');
        $label18 = new TLabel("Tipo da solução:", '', '14px', 'B', '100%');
        $text11 = new TTextDisplay($chamado->tipo_solucao->nome, '', '18px', '');
        $label2www = new TLabel(new TImage('far:comment-dots #607D8B')."Observações:<br/>", '#607D8B', '16px', 'B', '100%');
        $label22 = new TLabel("Abertura:", '', '14px', 'B', '100%');
        $text8 = new TTextDisplay($transformed_chamado_observacao_abertura, '', '14px', '');
        $label24 = new TLabel("Finalização:", '', '14px', 'B', '100%');
        $text13 = new TTextDisplay($transformed_chamado_observacao_finalizacao, '', '14px', '');
        $label4aa = new TLabel(" ", '', '12px', '', '100%');
        $novanota = new TActionLink("Adicionar nota", new TAction(['NotaForm', 'onShowView'], ['chamado_id'=> $chamado->id]), '', '12px', '', 'far:comment-dots #FF5722');
        $bpagecontainer2 = new BPageContainer();

        $label2->enableToggleVisibility(false);
        $bpagecontainer2->setSize('100%');
        $bpagecontainer2->setAction(new TAction(['NotaTimeLine', 'onShow'], ['chamado_id' => $chamado->id]));
        $bpagecontainer2->setId('b62c842eb7c361');

        $novanota->class = 'btn btn-default';

        $loadingContainer = new TElement('div');
        $loadingContainer->style = 'text-align:center; padding:50px';

        $icon = new TElement('i');
        $icon->class = 'fas fa-spinner fa-spin fa-3x';

        $loadingContainer->add($icon);
        $loadingContainer->add('<br>Carregando');

        $bpagecontainer2->add($loadingContainer);


        $row1 = $this->form->addFields([$label2111,$text1211],[],[$label10,$text5]);
        $row1->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row2 = $this->form->addFields([$label2,$text2],[$label62,$text7],[$label20,$text12]);
        $row2->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row3 = $this->form->addFields([$label41,$text3],[$label81,$text4],[$label12,$text6]);
        $row3->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row4 = $this->form->addFields([$label141,$text9],[$label16,$text101],[$label18,$text11]);
        $row4->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row5 = $this->form->addFields([$label2www],[$label22,$text8],[$label24,$text13],[$label4aa]);
        $row5->layout = [' col-sm-12',' col-sm-6','col-sm-6',' col-sm-12'];

        $tab_detalhes = new BootstrapFormBuilder('tab_detalhes');
        $this->tab_detalhes = $tab_detalhes;
        $tab_detalhes->setProperty('style', 'border:none; box-shadow:none;');

        $tab_detalhes->appendPage("Notas");

        $tab_detalhes->addFields([new THidden('current_tab_tab_detalhes')]);
        $tab_detalhes->setTabFunction("$('[name=current_tab_tab_detalhes]').val($(this).attr('data-current_page'));");

        $row6 = $tab_detalhes->addFields([$novanota]);
        $row6->layout = ['col-sm-3'];

        $row7 = $tab_detalhes->addFields([$bpagecontainer2]);
        $row7->layout = [' col-sm-12'];

        $tab_detalhes->appendPage("Anexos");

        $this->arquivo_chamado_chamado_id_list = new TQuickGrid;
        $this->arquivo_chamado_chamado_id_list->disableHtmlConversion();
        $this->arquivo_chamado_chamado_id_list->style = 'width:100%';
        $this->arquivo_chamado_chamado_id_list->disableDefaultClick();

        $column_name_transformed = $this->arquivo_chamado_chamado_id_list->addQuickColumn("", 'name', 'left');

        $column_name_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            $value = explode(',', $value);
            if(count($value) == 0)
            {
                $value = $value[0];
            }

            if(is_array($value))
            {
                $files = $value;
                $divFiles = new TElement('div');
                foreach($files as $file)
                {
                    $fileName = $file;
                    if (strpos($file, '%7B') !== false) 
                    {
                        if (!empty($file)) 
                        {
                            $fileObject = json_decode(urldecode($file));

                            $fileName = $fileObject->fileName;
                        }
                    }

                    $a = new TElement('a');
                    $a->href = "download.php?file={$fileName}";
                    $a->class = 'btn btn-link';
                    $a->add($fileName);
                    $a->target = '_blank';

                    $divFiles->add($a);

                }

                return $divFiles;
            }
            else
            {
                if (strpos($value, '%7B') !== false) 
                {
                    if (!empty($value)) 
                    {
                        $value_object = json_decode(urldecode($value));
                        $value = $value_object->fileName;
                    }
                }

                if($value)
                {
                    $a = new TElement('a');
                    $a->href = "download.php?file={$value}";
                    $a->class = 'btn btn-default';
                    $a->add($value);
                    $a->target = '_blank';

                    return $a;
                }

                return $value;
            }
        });

        $this->arquivo_chamado_chamado_id_list->createModel();

        $criteria_arquivo_chamado_chamado_id = new TCriteria();
        $criteria_arquivo_chamado_chamado_id->add(new TFilter('chamado_id', '=', $chamado->id));

        $criteria_arquivo_chamado_chamado_id->setProperty('order', 'id desc');

        $arquivo_chamado_chamado_id_items = ArquivoChamado::getObjects($criteria_arquivo_chamado_chamado_id);

        $this->arquivo_chamado_chamado_id_list->addItems($arquivo_chamado_chamado_id_items);

        $panel = new TElement('div');
        $panel->class = 'formView-detail';
        $panel->add(new BootstrapDatagridWrapper($this->arquivo_chamado_chamado_id_list));

        $tab_detalhes->addContent([$panel]);
        $row8 = $this->form->addFields([$tab_detalhes]);
        $row8->layout = [' col-sm-12'];

        if(!empty($param['current_tab']))
        {
            $this->form->setCurrentPage($param['current_tab']);
        }

        if(!empty($param['current_tab_tab_detalhes']))
        {
            $this->tab_detalhes->setCurrentPage($param['current_tab_tab_detalhes']);
        }

        $documentoAction = new TAction(['ChamadoDocument', 'onGenerate'],['key'=>$chamado->id]);
        $documentoLabel = new TLabel("Ver documento");

        $documento = $this->form->addHeaderAction($documentoLabel, $documentoAction, 'fas:file-pdf #F44336'); 
        $documentoLabel->setFontSize('12px'); 
        $documentoLabel->setFontColor('#333'); 

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        TTransaction::close();
        parent::add($this->form);

        $style = new TStyle('right-panel > .container-part[page-name=ChamadoFormView]');
        $style->width = '85% !important';   
        $style->show(true);

    }

    public function onShow($param = null)
    {     

    }

}

