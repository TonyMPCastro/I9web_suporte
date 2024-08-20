<?php

class ChamadoList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'chamado';
    private static $activeRecord = 'Chamado';
    private static $primaryKey = 'id';
    private static $formName = 'form_ChamadoList';
    private $showMethods = ['onReload', 'onSearch', 'onRefresh', 'onClearFilters'];
    private $limit = 20;

    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct($param = null)
    {
        parent::__construct();

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);

        // define the form title
        $this->form->setFormTitle("Listagem de chamados");
        $this->limit = 20;

        $criteria_produto_id = new TCriteria();
        $criteria_prioridade_id = new TCriteria();
        $criteria_categoria_id = new TCriteria();
        $criteria_status_id = new TCriteria();
        $criteria_tipo_problema_id = new TCriteria();
        $criteria_tipo_solucao_id = new TCriteria();

        $filterVar = 'T';
        $criteria_produto_id->add(new TFilter('ativo', '=', $filterVar)); 
        $filterVar = 'T';
        $criteria_status_id->add(new TFilter('ativo', '=', $filterVar)); 

        $id = new TEntry('id');
        $solicitante_id = new TEntry('solicitante_id');
        $atendente_id = new TEntry('atendente_id');
        $produto_id = new TDBCombo('produto_id', 'chamado', 'Produto', 'id', '{nome}','nome asc' , $criteria_produto_id );
        $prioridade_id = new TDBCombo('prioridade_id', 'chamado', 'Prioridade', 'id', '{nome}','nome asc' , $criteria_prioridade_id );
        $categoria_id = new TDBCombo('categoria_id', 'chamado', 'Categoria', 'id', '{nome}','nome asc' , $criteria_categoria_id );
        $status_id = new TDBCombo('status_id', 'chamado', 'Status', 'id', '{nome}','nome asc' , $criteria_status_id );
        $tipo_problema_id = new TDBCombo('tipo_problema_id', 'chamado', 'TipoProblema', 'id', '{nome}','nome asc' , $criteria_tipo_problema_id );
        $tipo_solucao_id = new TDBCombo('tipo_solucao_id', 'chamado', 'TipoSolucao', 'id', '{nome}','nome asc' , $criteria_tipo_solucao_id );
        $recorente = new TCombo('recorente');
        $observacao_abertura = new TEntry('observacao_abertura');
        $observacao_finalizacao = new TEntry('observacao_finalizacao');
        $dt_abertura = new TDate('dt_abertura');
        $dt_abertura_fim = new TDate('dt_abertura_fim');
        $dt_fechamento = new TDate('dt_fechamento');
        $dt_fechamento_final = new TDate('dt_fechamento_final');


        $recorente->addItems(["T"=>"Sim","N"=>"Não"]);
        $dt_abertura->setMask('dd/mm/yyyy');
        $dt_fechamento->setMask('dd/mm/yyyy');
        $dt_abertura_fim->setMask('dd/mm/yyyy');
        $dt_fechamento_final->setMask('dd/mm/yyyy');

        $dt_abertura->setDatabaseMask('yyyy-mm-dd');
        $dt_fechamento->setDatabaseMask('yyyy-mm-dd');
        $dt_abertura_fim->setDatabaseMask('yyyy-mm-dd');
        $dt_fechamento_final->setDatabaseMask('yyyy-mm-dd');

        $status_id->enableSearch();
        $recorente->enableSearch();
        $produto_id->enableSearch();
        $categoria_id->enableSearch();
        $prioridade_id->enableSearch();
        $tipo_solucao_id->enableSearch();
        $tipo_problema_id->enableSearch();

        $id->setSize(100);
        $dt_abertura->setSize(150);
        $status_id->setSize('100%');
        $recorente->setSize('100%');
        $produto_id->setSize('100%');
        $dt_fechamento->setSize(150);
        $atendente_id->setSize('100%');
        $categoria_id->setSize('100%');
        $dt_abertura_fim->setSize(110);
        $prioridade_id->setSize('100%');
        $solicitante_id->setSize('100%');
        $tipo_solucao_id->setSize('100%');
        $tipo_problema_id->setSize('100%');
        $dt_fechamento_final->setSize(110);
        $observacao_abertura->setSize('100%');
        $observacao_finalizacao->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null, '100%'),$id]);
        $row1->layout = ['col-sm-6'];

        $row2 = $this->form->addFields([new TLabel("Solicitante:", null, '14px', null),$solicitante_id],[new TLabel("Atendente:", null, '14px', null),$atendente_id],[new TLabel("Produto:", null, '14px', null, '100%'),$produto_id]);
        $row2->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row3 = $this->form->addFields([new TLabel("Prioridade:", null, '14px', null),$prioridade_id],[new TLabel("Categoria:", null, '14px', null),$categoria_id],[new TLabel("Situação:", null, '14px', null),$status_id]);
        $row3->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row4 = $this->form->addFields([new TLabel("Tipo do problema:", null, '14px', null, '100%'),$tipo_problema_id],[new TLabel("Tipo da solução:", null, '14px', null, '100%'),$tipo_solucao_id],[new TLabel("Recorrente:", null, '14px', null, '100%'),$recorente]);
        $row4->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row5 = $this->form->addFields([new TLabel("Observação abertura:", null, '14px', null),$observacao_abertura],[new TLabel("Observação fechamento:", null, '14px', null),$observacao_finalizacao]);
        $row5->layout = ['col-sm-6','col-sm-6'];

        $row6 = $this->form->addFields([new TLabel("Abertura:", null, '14px', null, '100%'),$dt_abertura,new TLabel("até", null, '14px', null),$dt_abertura_fim],[new TLabel("Fechamento:", null, '14px', null, '100%'),$dt_fechamento,new TLabel("até", null, '14px', null),$dt_fechamento_final]);
        $row6->layout = ['col-sm-6','col-sm-6'];

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsearch = $this->form->addAction("Buscar", new TAction([$this, 'onSearch']), 'fas:search #ffffff');
        $this->btn_onsearch = $btn_onsearch;
        $btn_onsearch->addStyleClass('btn-primary'); 

        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid->disableHtmlConversion();
        $this->datagrid->setId(__CLASS__.'_datagrid');

        $this->datagrid_form = new TForm('datagrid_'.self::$formName);
        $this->datagrid_form->onsubmit = 'return false';

        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->filter_criteria = new TCriteria;

        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(250);

        $column_prioridade_cor_transformed = new TDataGridColumn('prioridade->cor', " ", 'center' , '50px');
        $column_id = new TDataGridColumn('id', "Id", 'center' , '70px');
        $column_dt_abertura_transformed = new TDataGridColumn('dt_abertura', "Abertura", 'left');
        $column_tipo_problema_nome = new TDataGridColumn('tipo_problema->nome', "Tipo do problema", 'left');
        $column_solicitante_id = new TDataGridColumn('solicitante->id', "Solicitante", 'left');
        $column_produto_nome = new TDataGridColumn('produto->nome', "Produto", 'left');
        $column_categoria_nome = new TDataGridColumn('categoria->nome', "Categoria", 'left');
        $column_status_nome_transformed = new TDataGridColumn('status->nome', "Situação", 'center' , '150px');

        $column_prioridade_cor_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {

            return "<div style='background-color: {$value} ; border-radius: 50%;border: 1px solid #f1f1f1;width: 20px; height: 20px;' title='{$object->prioridade->nome}'></div>";

        });

        $column_dt_abertura_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            if(!empty(trim($value)))
            {
                try
                {
                    $date = new DateTime($value);
                    return $date->format('d/m/Y');
                }
                catch (Exception $e)
                {
                    return $value;
                }
            }
        });

        $column_status_nome_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            return "<div class='label' style='background: {$object->status->cor} ; width: 100%; color: white;'>{$value}</div>";

        });        

        $order_id = new TAction(array($this, 'onReload'));
        $order_id->setParameter('order', 'id');
        $column_id->setAction($order_id);
        $order_dt_abertura_transformed = new TAction(array($this, 'onReload'));
        $order_dt_abertura_transformed->setParameter('order', 'dt_abertura');
        $column_dt_abertura_transformed->setAction($order_dt_abertura_transformed);

        $this->datagrid->addColumn($column_prioridade_cor_transformed);
        $this->datagrid->addColumn($column_id);
        $this->datagrid->addColumn($column_dt_abertura_transformed);
        $this->datagrid->addColumn($column_tipo_problema_nome);
        $this->datagrid->addColumn($column_solicitante_id);
        $this->datagrid->addColumn($column_produto_nome);
        $this->datagrid->addColumn($column_categoria_nome);
        $this->datagrid->addColumn($column_status_nome_transformed);

        $action_onEdit = new TDataGridAction(array('ChamadoForm', 'onEdit'));
        $action_onEdit->setUseButton(false);
        $action_onEdit->setButtonClass('btn btn-default btn-sm');
        $action_onEdit->setLabel("Editar");
        $action_onEdit->setImage('fas:edit #2196F3');
        $action_onEdit->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onEdit);

        $action_onShow = new TDataGridAction(array('ChamadoFormView', 'onShow'));
        $action_onShow->setUseButton(false);
        $action_onShow->setButtonClass('btn btn-default btn-sm');
        $action_onShow->setLabel("Visualizar");
        $action_onShow->setImage('fas:search #4CAF50');
        $action_onShow->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onShow);

        $action_onGenerate = new TDataGridAction(array('ChamadoDocument', 'onGenerate'));
        $action_onGenerate->setUseButton(false);
        $action_onGenerate->setButtonClass('btn btn-default btn-sm');
        $action_onGenerate->setLabel("Documento");
        $action_onGenerate->setImage('fas:file-pdf #F44336');
        $action_onGenerate->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onGenerate);

        $action_NotaForm_onShow = new TDataGridAction(array('NotaForm', 'onShow'));
        $action_NotaForm_onShow->setUseButton(false);
        $action_NotaForm_onShow->setButtonClass('btn btn-default btn-sm');
        $action_NotaForm_onShow->setLabel("Nova nota");
        $action_NotaForm_onShow->setImage('far:comment-dots #FF9800');
        $action_NotaForm_onShow->setField(self::$primaryKey);

        $action_NotaForm_onShow->setParameter('chamado_id', '{id}');

        $this->datagrid->addAction($action_NotaForm_onShow);

        // create the datagrid model
        $this->datagrid->createModel();

        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->enableCounters();
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        $panel = new TPanelGroup("Listagem de chamados");
        $panel->datagrid = 'datagrid-container';
        $this->datagridPanel = $panel;
        $this->datagrid_form->add($this->datagrid);
        $panel->add($this->datagrid_form);

        $panel->getBody()->class .= ' table-responsive';

        $panel->addFooter($this->pageNavigation);

        $headerActions = new TElement('div');
        $headerActions->class = ' datagrid-header-actions ';
        $headerActions->style = 'justify-content: space-between;';

        $head_left_actions = new TElement('div');
        $head_left_actions->class = ' datagrid-header-actions-left-actions ';

        $head_right_actions = new TElement('div');
        $head_right_actions->class = ' datagrid-header-actions-left-actions ';

        $headerActions->add($head_left_actions);
        $headerActions->add($head_right_actions);

        $panel->getBody()->insert(0, $headerActions);

        $button_cadastrar = new TButton('button_button_cadastrar');
        $button_cadastrar->setAction(new TAction(['ChamadoForm', 'onShow']), "Cadastrar");
        $button_cadastrar->addStyleClass('btn-default');
        $button_cadastrar->setImage('fas:plus #69aa46');

        $this->datagrid_form->addField($button_cadastrar);

        $btnShowCurtainFilters = new TButton('button_btnShowCurtainFilters');
        $btnShowCurtainFilters->setAction(new TAction(['ChamadoList', 'onShowCurtainFilters']), "Filtros");
        $btnShowCurtainFilters->addStyleClass('btn-default');
        $btnShowCurtainFilters->setImage('fas:filter #000000');

        $this->datagrid_form->addField($btnShowCurtainFilters);

        $button_atualizar = new TButton('button_button_atualizar');
        $button_atualizar->setAction(new TAction(['ChamadoList', 'onRefresh']), "Atualizar");
        $button_atualizar->addStyleClass('btn-default');
        $button_atualizar->setImage('fas:sync-alt #03a9f4');

        $this->datagrid_form->addField($button_atualizar);

        $button_limpar_filtros = new TButton('button_button_limpar_filtros');
        $button_limpar_filtros->setAction(new TAction(['ChamadoList', 'onClearFilters']), "Limpar filtros");
        $button_limpar_filtros->addStyleClass('btn-default');
        $button_limpar_filtros->setImage('fas:eraser #f44336');

        $this->datagrid_form->addField($button_limpar_filtros);

        $dropdown_button_exportar = new TDropDown("Exportar", 'fas:file-export #2d3436');
        $dropdown_button_exportar->setPullSide('right');
        $dropdown_button_exportar->setButtonClass('btn btn-default waves-effect dropdown-toggle');
        $dropdown_button_exportar->addPostAction( "CSV", new TAction(['ChamadoList', 'onExportCsv'],['static' => 1]), 'datagrid_'.self::$formName, 'fas:file-csv #00b894' );
        $dropdown_button_exportar->addPostAction( "XLS", new TAction(['ChamadoList', 'onExportXls'],['static' => 1]), 'datagrid_'.self::$formName, 'fas:file-excel #4CAF50' );
        $dropdown_button_exportar->addPostAction( "PDF", new TAction(['ChamadoList', 'onExportPdf'],['static' => 1]), 'datagrid_'.self::$formName, 'far:file-pdf #e74c3c' );
        $dropdown_button_exportar->addPostAction( "XML", new TAction(['ChamadoList', 'onExportXml'],['static' => 1]), 'datagrid_'.self::$formName, 'far:file-code #95a5a6' );

        $head_left_actions->add($button_cadastrar);
        $head_left_actions->add($btnShowCurtainFilters);
        $head_left_actions->add($button_atualizar);
        $head_left_actions->add($button_limpar_filtros);

        $head_right_actions->add($dropdown_button_exportar);

        $this->btnShowCurtainFilters = $btnShowCurtainFilters;

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Atendente","Chamados"]));
        }

        $container->add($panel);

        try {
            TTransaction::open(self::$database);
            $preferences = SystemPreference::getAllPreferences();

            if (empty($preferences['mail_from']) || empty($preferences['smtp_user']) || empty($preferences['smtp_pass']) || empty($preferences['smtp_host']) || empty($preferences['smtp_port']))
            {
                $aviso = new TElement('div');
                $aviso->class = 'label warning';
                $aviso->add('<b>Atenção!</b> A configuração do e-mail não foi realizada, por isso os e-mails de abertura e finalização de chamado não serão enviados.');
                $container->insert(0, $aviso);
            }
            TTransaction::close();
        } catch (Exception $e) {
            TTransaction::rollback();
        }

        parent::add($container);

    }

    public function onExportCsv($param = null) 
    {
        try
        {
            $output = 'app/output/'.uniqid().'.csv';

            if ( (!file_exists($output) && is_writable(dirname($output))) OR is_writable($output))
            {
                $this->limit = 0;
                $objects = $this->onReload();

                if ($objects)
                {
                    $handler = fopen($output, 'w');
                    TTransaction::open(self::$database);

                    foreach ($objects as $object)
                    {
                        $row = [];
                        foreach ($this->datagrid->getColumns() as $column)
                        {
                            $column_name = $column->getName();

                            if (isset($object->$column_name))
                            {
                                $row[] = is_scalar($object->$column_name) ? $object->$column_name : '';
                            }
                            else if (method_exists($object, 'render'))
                            {
                                $column_name = (strpos($column_name, '{') === FALSE) ? ( '{' . $column_name . '}') : $column_name;
                                $row[] = $object->render($column_name);
                            }
                        }

                        fputcsv($handler, $row);
                    }

                    fclose($handler);
                    TTransaction::close();
                }
                else
                {
                    throw new Exception(_t('No records found'));
                }

                TPage::openFile($output);
            }
            else
            {
                throw new Exception(_t('Permission denied') . ': ' . $output);
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
        }
    }
    public function onExportXls($param = null) 
    {
        try
        {
            $output = 'app/output/'.uniqid().'.xls';

            if ( (!file_exists($output) && is_writable(dirname($output))) OR is_writable($output))
            {
                $widths = [];
                $titles = [];

                foreach ($this->datagrid->getColumns() as $column)
                {
                    $titles[] = $column->getLabel();
                    $width    = 100;

                    if (is_null($column->getWidth()))
                    {
                        $width = 100;
                    }
                    else if (strpos($column->getWidth(), '%') !== false)
                    {
                        $width = ((int) $column->getWidth()) * 5;
                    }
                    else if (is_numeric($column->getWidth()))
                    {
                        $width = $column->getWidth();
                    }

                    $widths[] = $width;
                }

                $table = new \TTableWriterXLS($widths);
                $table->addStyle('title',  'Helvetica', '10', 'B', '#ffffff', '#617FC3');
                $table->addStyle('data',   'Helvetica', '10', '',  '#000000', '#FFFFFF', 'LR');

                $table->addRow();

                foreach ($titles as $title)
                {
                    $table->addCell($title, 'center', 'title');
                }

                $this->limit = 0;
                $objects = $this->onReload();

                TTransaction::open(self::$database);
                if ($objects)
                {
                    foreach ($objects as $object)
                    {
                        $table->addRow();
                        foreach ($this->datagrid->getColumns() as $column)
                        {
                            $column_name = $column->getName();
                            $value = '';
                            if (isset($object->$column_name))
                            {
                                $value = is_scalar($object->$column_name) ? $object->$column_name : '';
                            }
                            else if (method_exists($object, 'render'))
                            {
                                $column_name = (strpos($column_name, '{') === FALSE) ? ( '{' . $column_name . '}') : $column_name;
                                $value = $object->render($column_name);
                            }

                            $transformer = $column->getTransformer();
                            if ($transformer)
                            {
                                $value = strip_tags(call_user_func($transformer, $value, $object, null));
                            }

                            $table->addCell($value, 'center', 'data');
                        }
                    }
                }
                $table->save($output);
                TTransaction::close();

                TPage::openFile($output);
            }
            else
            {
                throw new Exception(_t('Permission denied') . ': ' . $output);
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
        }
    }
    public function onExportPdf($param = null) 
    {
        try
        {
            $output = 'app/output/'.uniqid().'.pdf';

            if ( (!file_exists($output) && is_writable(dirname($output))) OR is_writable($output))
            {
                $this->limit = 0;
                $this->datagrid->prepareForPrinting();
                $this->onReload();

                $html = clone $this->datagrid;
                $contents = file_get_contents('app/resources/styles-print.html') . $html->getContents();

                $dompdf = new \Dompdf\Dompdf;
                $dompdf->loadHtml($contents);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();

                file_put_contents($output, $dompdf->output());

                $window = TWindow::create('PDF', 0.8, 0.8);
                $object = new TElement('object');
                $object->data  = $output;
                $object->type  = 'application/pdf';
                $object->style = "width: 100%; height:calc(100% - 10px)";

                $window->add($object);
                $window->show();
            }
            else
            {
                throw new Exception(_t('Permission denied') . ': ' . $output);
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
        }
    }
    public function onExportXml($param = null) 
    {
        try
        {
            $output = 'app/output/'.uniqid().'.xml';

            if ( (!file_exists($output) && is_writable(dirname($output))) OR is_writable($output))
            {
                $this->limit = 0;
                $objects = $this->onReload();

                if ($objects)
                {
                    TTransaction::open(self::$database);

                    $dom = new DOMDocument('1.0', 'UTF-8');
                    $dom->{'formatOutput'} = true;
                    $dataset = $dom->appendChild( $dom->createElement('dataset') );

                    foreach ($objects as $object)
                    {
                        $row = $dataset->appendChild( $dom->createElement( self::$activeRecord ) );

                        foreach ($this->datagrid->getColumns() as $column)
                        {
                            $column_name = $column->getName();
                            $column_name_raw = str_replace(['(','{','->', '-','>','}',')', ' '], ['','','_','','','','','_'], $column_name);

                            if (isset($object->$column_name))
                            {
                                $value = is_scalar($object->$column_name) ? $object->$column_name : '';
                                $row->appendChild($dom->createElement($column_name_raw, $value)); 
                            }
                            else if (method_exists($object, 'render'))
                            {
                                $column_name = (strpos($column_name, '{') === FALSE) ? ( '{' . $column_name . '}') : $column_name;
                                $value = $object->render($column_name);
                                $row->appendChild($dom->createElement($column_name_raw, $value));
                            }
                        }
                    }

                    $dom->save($output);

                    TTransaction::close();
                }
                else
                {
                    throw new Exception(_t('No records found'));
                }

                TPage::openFile($output);
            }
            else
            {
                throw new Exception(_t('Permission denied') . ': ' . $output);
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }
    public static function onShowCurtainFilters($param = null) 
    {
        try 
        {
            //code here

                        $filter = new self([]);

            $btnClose = new TButton('closeCurtain');
            $btnClose->class = 'btn btn-sm btn-default';
            $btnClose->style = 'margin-right:10px;';
            $btnClose->onClick = "Template.closeRightPanel();";
            $btnClose->setLabel("Fechar");
            $btnClose->setImage('fas:times');

            $filter->form->addHeaderWidget($btnClose);

            $page = new TPage();
            $page->setTargetContainer('adianti_right_panel');
            $page->setProperty('page-name', 'ChamadoListSearch');
            $page->setProperty('page_name', 'ChamadoListSearch');
            $page->adianti_target_container = 'adianti_right_panel';
            $page->target_container = 'adianti_right_panel';
            $page->add($filter->form);
            $page->setIsWrapped(true);
            $page->show();

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public function onRefresh($param = null) 
    {
        $this->onReload([]);
    }
    public function onClearFilters($param = null) 
    {
        TSession::setValue(__CLASS__.'_filter_data', NULL);
        TSession::setValue(__CLASS__.'_filters', NULL);

        $this->onReload(['offset' => 0, 'first_page' => 1]);
    }

    /**
     * Register the filter in the session
     */
    public function onSearch($param = null)
    {
        $data = $this->form->getData();
        $filters = [];

        TSession::setValue(__CLASS__.'_filter_data', NULL);
        TSession::setValue(__CLASS__.'_filters', NULL);

        if (isset($data->id) AND ( (is_scalar($data->id) AND $data->id !== '') OR (is_array($data->id) AND (!empty($data->id)) )) )
        {

            $filters[] = new TFilter('id', '=', $data->id);// create the filter 
        }

        if (isset($data->solicitante_id) AND ( (is_scalar($data->solicitante_id) AND $data->solicitante_id !== '') OR (is_array($data->solicitante_id) AND (!empty($data->solicitante_id)) )) )
        {

            $filters[] = new TFilter('solicitante_id', '=', $data->solicitante_id);// create the filter 
        }

        if (isset($data->atendente_id) AND ( (is_scalar($data->atendente_id) AND $data->atendente_id !== '') OR (is_array($data->atendente_id) AND (!empty($data->atendente_id)) )) )
        {

            $filters[] = new TFilter('atendente_id', '=', $data->atendente_id);// create the filter 
        }

        if (isset($data->produto_id) AND ( (is_scalar($data->produto_id) AND $data->produto_id !== '') OR (is_array($data->produto_id) AND (!empty($data->produto_id)) )) )
        {

            $filters[] = new TFilter('produto_id', '=', $data->produto_id);// create the filter 
        }

        if (isset($data->prioridade_id) AND ( (is_scalar($data->prioridade_id) AND $data->prioridade_id !== '') OR (is_array($data->prioridade_id) AND (!empty($data->prioridade_id)) )) )
        {

            $filters[] = new TFilter('prioridade_id', '=', $data->prioridade_id);// create the filter 
        }

        if (isset($data->categoria_id) AND ( (is_scalar($data->categoria_id) AND $data->categoria_id !== '') OR (is_array($data->categoria_id) AND (!empty($data->categoria_id)) )) )
        {

            $filters[] = new TFilter('categoria_id', '=', $data->categoria_id);// create the filter 
        }

        if (isset($data->status_id) AND ( (is_scalar($data->status_id) AND $data->status_id !== '') OR (is_array($data->status_id) AND (!empty($data->status_id)) )) )
        {

            $filters[] = new TFilter('status_id', '=', $data->status_id);// create the filter 
        }

        if (isset($data->tipo_problema_id) AND ( (is_scalar($data->tipo_problema_id) AND $data->tipo_problema_id !== '') OR (is_array($data->tipo_problema_id) AND (!empty($data->tipo_problema_id)) )) )
        {

            $filters[] = new TFilter('tipo_problema_id', '=', $data->tipo_problema_id);// create the filter 
        }

        if (isset($data->tipo_solucao_id) AND ( (is_scalar($data->tipo_solucao_id) AND $data->tipo_solucao_id !== '') OR (is_array($data->tipo_solucao_id) AND (!empty($data->tipo_solucao_id)) )) )
        {

            $filters[] = new TFilter('tipo_solucao_id', '=', $data->tipo_solucao_id);// create the filter 
        }

        if (isset($data->recorente) AND ( (is_scalar($data->recorente) AND $data->recorente !== '') OR (is_array($data->recorente) AND (!empty($data->recorente)) )) )
        {

            $filters[] = new TFilter('recorente', '=', $data->recorente);// create the filter 
        }

        if (isset($data->observacao_abertura) AND ( (is_scalar($data->observacao_abertura) AND $data->observacao_abertura !== '') OR (is_array($data->observacao_abertura) AND (!empty($data->observacao_abertura)) )) )
        {

            $filters[] = new TFilter('observacao_abertura', 'ilike', "%{$data->observacao_abertura}%");// create the filter 
        }

        if (isset($data->observacao_finalizacao) AND ( (is_scalar($data->observacao_finalizacao) AND $data->observacao_finalizacao !== '') OR (is_array($data->observacao_finalizacao) AND (!empty($data->observacao_finalizacao)) )) )
        {

            $filters[] = new TFilter('observacao_finalizacao', 'ilike', "%{$data->observacao_finalizacao}%");// create the filter 
        }

        if (isset($data->dt_abertura) AND ( (is_scalar($data->dt_abertura) AND $data->dt_abertura !== '') OR (is_array($data->dt_abertura) AND (!empty($data->dt_abertura)) )) )
        {

            $filters[] = new TFilter('dt_abertura', '>=', $data->dt_abertura);// create the filter 
        }

        if (isset($data->dt_abertura_fim) AND ( (is_scalar($data->dt_abertura_fim) AND $data->dt_abertura_fim !== '') OR (is_array($data->dt_abertura_fim) AND (!empty($data->dt_abertura_fim)) )) )
        {

            $filters[] = new TFilter('dt_abertura', '<=', $data->dt_abertura_fim);// create the filter 
        }

        if (isset($data->dt_fechamento) AND ( (is_scalar($data->dt_fechamento) AND $data->dt_fechamento !== '') OR (is_array($data->dt_fechamento) AND (!empty($data->dt_fechamento)) )) )
        {

            $filters[] = new TFilter('dt_fechamento', '>=', $data->dt_fechamento);// create the filter 
        }

        if (isset($data->dt_fechamento_final) AND ( (is_scalar($data->dt_fechamento_final) AND $data->dt_fechamento_final !== '') OR (is_array($data->dt_fechamento_final) AND (!empty($data->dt_fechamento_final)) )) )
        {

            $filters[] = new TFilter('dt_fechamento', '<=', $data->dt_fechamento_final);// create the filter 
        }

        // fill the form with data again
        $this->form->setData($data);

        // keep the search data in the session
        TSession::setValue(__CLASS__.'_filter_data', $data);
        TSession::setValue(__CLASS__.'_filters', $filters);

        $this->onReload(['offset' => 0, 'first_page' => 1]);
    }

    /**
     * Load the datagrid with data
     */
    public function onReload($param = NULL)
    {
        try
        {
            // open a transaction with database 'chamado'
            TTransaction::open(self::$database);

            // creates a repository for Chamado
            $repository = new TRepository(self::$activeRecord);

            $criteria = clone $this->filter_criteria;

            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $this->limit);

            if($filters = TSession::getValue(__CLASS__.'_filters'))
            {
                foreach ($filters as $filter) 
                {
                    $criteria->add($filter);       
                }
            }

            if (empty($param['order']))
            {
                $criteria->setProperty('order', '(SELECT ordem FROM prioridade WHERE prioridade_id = prioridade.id) asc, dt_abertura desc');
            }

            //</blockLine><btnShowCurtainFiltersAutoCode>
            if(!empty($this->btnShowCurtainFilters) && empty($this->btnShowCurtainFiltersAdjusted))
            {
                $this->btnShowCurtainFiltersAdjusted = true;
                $this->btnShowCurtainFilters->style = 'position: relative';
                $countFilters = count($filters ?? []);
                $this->btnShowCurtainFilters->setLabel($this->btnShowCurtainFilters->getLabel(). "<span class='badge badge-success' style='position: absolute'>{$countFilters}<span>");
            }
            //</blockLine></btnShowCurtainFiltersAutoCode>

            // load the objects according to criteria
            $objects = $repository->load($criteria, FALSE);

            $this->datagrid->clear();
            if ($objects)
            {
                // iterate the collection of active records
                foreach ($objects as $object)
                {

                    $row = $this->datagrid->addItem($object);
                    $row->id = "row_{$object->id}";

                }
            }

            // reset the criteria for record count
            $criteria->resetProperties();
            $count= $repository->count($criteria);

            $this->pageNavigation->setCount($count); // count of records
            $this->pageNavigation->setProperties($param); // order, page
            $this->pageNavigation->setLimit($this->limit); // limit

            // close the transaction
            TTransaction::close();
            $this->loaded = true;

            return $objects;
        }
        catch (Exception $e) // in case of exception
        {
            // shows the exception error message
            new TMessage('error', $e->getMessage());
            // undo all pending operations
            TTransaction::rollback();
        }
    }

    public function onShow($param = null)
    {

    }

    /**
     * method show()
     * Shows the page
     */
    public function show()
    {
        // check if the datagrid is already loaded
        if (!$this->loaded AND (!isset($_GET['method']) OR !(in_array($_GET['method'],  $this->showMethods))) )
        {
            if (func_num_args() > 0)
            {
                $this->onReload( func_get_arg(0) );
            }
            else
            {
                $this->onReload();
            }
        }
        parent::show();
    }

    public static function manageRow($id)
    {
        $list = new self([]);

        $openTransaction = TTransaction::getDatabase() != self::$database ? true : false;

        if($openTransaction)
        {
            TTransaction::open(self::$database);    
        }

        $object = new Chamado($id);

        $row = $list->datagrid->addItem($object);
        $row->id = "row_{$object->id}";

        if($openTransaction)
        {
            TTransaction::close();    
        }

        TDataGrid::replaceRowById(__CLASS__.'_datagrid', $row->id, $row);
    }

}

