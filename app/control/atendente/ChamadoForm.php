<?php

class ChamadoForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'chamado';
    private static $activeRecord = 'Chamado';
    private static $primaryKey = 'id';
    private static $formName = 'form_ChamadoForm';

    use Adianti\Base\AdiantiFileSaveTrait;

    use Adianti\Base\AdiantiFileSaveTrait;
    use BuilderMasterDetailFieldListTrait;

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

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("Cadastro de chamado");

        $criteria_produto_id = new TCriteria();
        $criteria_categoria_id = new TCriteria();
        $criteria_prioridade_id = new TCriteria();
        $criteria_status_id = new TCriteria();
        $criteria_tipo_problema_id = new TCriteria();
        $criteria_tipo_solucao_id = new TCriteria();

        $id = new TEntry('id');
        $dt_abertura = new TDateTime('dt_abertura');
        $dt_fechamento = new TDateTime('dt_fechamento');
        $solicitante_id = new TEntry('solicitante_id');
        $produto_id = new TDBCombo('produto_id', 'chamado', 'Produto', 'id', '{nome}','nome asc' , $criteria_produto_id );
        $categoria_id = new TDBCombo('categoria_id', 'chamado', 'Categoria', 'id', '{nome}','nome asc' , $criteria_categoria_id );
        $prioridade_id = new TDBCombo('prioridade_id', 'chamado', 'Prioridade', 'id', '{nome}','nome asc' , $criteria_prioridade_id );
        $status_id = new TDBCombo('status_id', 'chamado', 'Status', 'id', '{nome}','nome asc' , $criteria_status_id );
        $observacao_abertura = new TText('observacao_abertura');
        $tipo_problema_id = new TDBCombo('tipo_problema_id', 'chamado', 'TipoProblema', 'id', '{nome}','nome asc' , $criteria_tipo_problema_id );
        $tipo_solucao_id = new TDBCombo('tipo_solucao_id', 'chamado', 'TipoSolucao', 'id', '{nome}','nome asc' , $criteria_tipo_solucao_id );
        $recorente = new TRadioGroup('recorente');
        $tempo_trabalho = new TTime('tempo_trabalho');
        $observacao_finalizacao = new TText('observacao_finalizacao');
        $arquivo_chamado_chamado_id = new THidden('arquivo_chamado_chamado_id[]');
        $arquivo_chamado_chamado___row__id = new THidden('arquivo_chamado_chamado___row__id[]');
        $arquivo_chamado_chamado___row__data = new THidden('arquivo_chamado_chamado___row__data[]');
        $arquivo_chamado_chamado_name = new TFile('arquivo_chamado_chamado_name[]');
        $this->fieldList_arquivos = new TFieldList();

        $this->fieldList_arquivos->addField(null, $arquivo_chamado_chamado_id, []);
        $this->fieldList_arquivos->addField(null, $arquivo_chamado_chamado___row__id, ['uniqid' => true]);
        $this->fieldList_arquivos->addField(null, $arquivo_chamado_chamado___row__data, []);
        $this->fieldList_arquivos->addField(new TLabel("Arquivo", null, '14px', null), $arquivo_chamado_chamado_name, ['width' => '50%']);

        $this->fieldList_arquivos->width = '100%';
        $this->fieldList_arquivos->setFieldPrefix('arquivo_chamado_chamado');
        $this->fieldList_arquivos->name = 'fieldList_arquivos';

        $this->criteria_fieldList_arquivos = new TCriteria();
        $this->default_item_fieldList_arquivos = new stdClass();

        $this->form->addField($arquivo_chamado_chamado_id);
        $this->form->addField($arquivo_chamado_chamado___row__id);
        $this->form->addField($arquivo_chamado_chamado___row__data);
        $this->form->addField($arquivo_chamado_chamado_name);

        $this->fieldList_arquivos->setRemoveAction(null, 'fas:times #dd5a43', "Excluír");

        $dt_abertura->addValidation("Abertura", new TRequiredValidator()); 
        $solicitante_id->addValidation("Cliente", new TRequiredValidator()); 
        $produto_id->addValidation("Produto", new TRequiredValidator()); 
        $categoria_id->addValidation("Categoria", new TRequiredValidator()); 
        $prioridade_id->addValidation("Prioridade", new TRequiredValidator()); 
        $status_id->addValidation("Situação", new TRequiredValidator()); 
        $observacao_abertura->addValidation("Observação", new TRequiredValidator()); 

        $recorente->addItems(["T"=>"Sim","F"=>"Não"]);
        $recorente->setLayout('horizontal');
        $recorente->setUseButton();
        $arquivo_chamado_chamado_name->enableFileHandling();
        $dt_abertura->setMask('dd/mm/yyyy hh:ii');
        $dt_fechamento->setMask('dd/mm/yyyy hh:ii');

        $dt_abertura->setDatabaseMask('yyyy-mm-dd hh:ii');
        $dt_fechamento->setDatabaseMask('yyyy-mm-dd hh:ii');

        $recorente->setValue('F');
        $dt_abertura->setValue(date('d/m/Y H:i'));
        $solicitante_id->setValue(TSession::getValue('userid'));

        $id->setEditable(false);
        $dt_abertura->setEditable(false);
        $dt_fechamento->setEditable(false);
        $solicitante_id->setEditable(false);

        $status_id->enableSearch();
        $produto_id->enableSearch();
        $categoria_id->enableSearch();
        $prioridade_id->enableSearch();
        $tipo_solucao_id->enableSearch();
        $tipo_problema_id->enableSearch();

        $id->setSize(100);
        $status_id->setSize('100%');
        $recorente->setSize('100%');
        $produto_id->setSize('100%');
        $dt_abertura->setSize('100%');
        $categoria_id->setSize('100%');
        $dt_fechamento->setSize('100%');
        $prioridade_id->setSize('100%');
        $solicitante_id->setSize('100%');
        $tempo_trabalho->setSize('100%');
        $tipo_solucao_id->setSize('100%');
        $tipo_problema_id->setSize('100%');
        $observacao_abertura->setSize('100%', 70);
        $observacao_finalizacao->setSize('100%', 70);
        $arquivo_chamado_chamado_name->setSize('100%');

        $observacao_abertura->placeholder = "Descreva o problema";

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null, '100%'),$id],[new TLabel("Abertura:", null, '14px', null, '100%'),$dt_abertura],[new TLabel("Data fechamento:", null, '14px', null, '100%'),$dt_fechamento]);
        $row1->layout = ['col-sm-6',' col-sm-3',' col-sm-3'];

        $row2 = $this->form->addFields([new TLabel("Cliente:", '#FF0000', '14px', null, '100%'),$solicitante_id],[new TLabel("Produto:", '#ff0000', '14px', null, '100%'),$produto_id],[new TLabel("Categoria:", '#ff0000', '14px', null, '100%'),$categoria_id]);
        $row2->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row3 = $this->form->addFields([new TLabel("Prioridade:", '#ff0000', '14px', null, '100%'),$prioridade_id],[new TLabel("Situação:", '#ff0000', '14px', null, '100%'),$status_id]);
        $row3->layout = ['col-sm-6','col-sm-6'];

        $row4 = $this->form->addFields([new TLabel("Observação:", '#ff0000', '14px', null, '100%'),$observacao_abertura]);
        $row4->layout = [' col-sm-12'];

        $row5 = $this->form->addFields([new TLabel("Tipo do problema:", null, '14px', null, '100%'),$tipo_problema_id],[new TLabel("Tipo da solução:", null, '14px', null, '100%'),$tipo_solucao_id],[new TLabel("Recorrente:", null, '14px', null, '100%'),$recorente],[new TLabel("Tempo:", null, '14px', null, '100%'),$tempo_trabalho]);
        $row5->layout = [' col-sm-3',' col-sm-3',' col-sm-3',' col-sm-3'];

        $row6 = $this->form->addFields([new TLabel("Observação de finalização:", null, '14px', null, '100%'),$observacao_finalizacao]);
        $row6->layout = [' col-sm-12'];

        $row7 = $this->form->addFields([$this->fieldList_arquivos]);
        $row7->layout = [' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave'],['static' => 1]), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['ChamadoList', 'onShow']), 'fas:arrow-left #000000');
        $this->btn_onshow = $btn_onshow;

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);

        $style = new TStyle('right-panel > .container-part[page-name=ChamadoForm]');
        $style->width = '85% !important';   
        $style->show(true);

    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new Chamado(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            if (empty($data->id))
            {
                $object->mes_abertura = date('m');
                $object->ano_abertura = date('Y');
                $object->anomes_abertura = date('Ym');
            }

            if ($object->status->estado_final == 'T')
            {
                $object->dt_fechamento = date('Y-m-d H:i');
                $object->mes_fechamento = date('m');
                $object->ano_fechamento = date('Y');
                $object->anomes_fechamento = date('Ym');
            }

            if ($object->status->estado_final == 'T')
            {
                if (! $object->observacao_finalizacao)
                    throw new Exception('Observação de finalização é obrigatória');
            }

            $arquivo_chamado_chamado_name_dir = 'anexos';  

            $object->store(); // save the object 

            if ($object->status->estado_final == 'T')
            {
                try
                {
                    $preferences = SystemPreference::getAllPreferences();

                    if (! empty($preferences['mail_from']) && ! empty($preferences['smtp_user']) && ! empty($preferences['smtp_pass']) && ! empty($preferences['smtp_host']) && ! empty($preferences['smtp_port']))
                    {
                        $template = Template::find(Template::EMAIL_FECHAMENTO_CHAMADO);
                        $arquivos = $object->getArquivoChamados();
                        $anexos = [];

                        if ($arquivos)
                        {
                            foreach($arquivos as $arquivo)
                            {
                                $anexos[] = [$arquivo->name];
                            }
                        }

                        MailService::send($object->solicitante->system_user->email, $template->parserTitulo($object), $template->parserTemplate($object), 'html', $anexos);
                    }
                }
                catch(Exception $e)
                {
                    TToast::show('warning', 'E-mail de finalização não enviado: ' . $e->getMessage(), 'topRight');
                }
            }

            $loadPageParam = [];

            if(!empty($param['target_container']))
            {
                $loadPageParam['target_container'] = $param['target_container'];
            }

            $aenxos_data = $this->fieldList_arquivos->getPostData();
            if(count($aenxos_data) == 1 && empty($aenxos_data[0]->name))
            {
                ArquivoChamado::where('chamado_id', '=', $object->id)->delete();
            }
            else
            {
            $arquivo_chamado_chamado_items = $this->storeItems('ArquivoChamado', 'chamado_id', $object, $this->fieldList_arquivos, function($masterObject, $detailObject){ 

                if (! $detailObject->name) {
                    throw new Exception('Arquivo é obrigatório');
                }

            }, $this->criteria_fieldList_arquivos); 
            if(!empty($arquivo_chamado_chamado_items))
            {
                foreach ($arquivo_chamado_chamado_items as $item)
                {
                    $dataFile = new stdClass();
                    $dataFile->name = $item->name;
                    $this->saveFile($item, $dataFile, 'name', $arquivo_chamado_chamado_name_dir);
                }
            }

            }

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            TToast::show('success', "Registro salvo", 'topRight', 'far:check-circle');
            TApplication::loadPage('ChamadoList', 'onShow', $loadPageParam); 

                        TScript::create("Template.closeRightPanel();");
            TForm::sendData(self::$formName, (object)['id' => $object->id]);

        }
        catch (Exception $e) // in case of exception
        {
            //</catchAutoCode> 

            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
    }

    public function onEdit( $param )
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $object = new Chamado($key); // instantiates the Active Record 

                $this->fieldList_arquivos_items = $this->loadItems('ArquivoChamado', 'chamado_id', $object, $this->fieldList_arquivos, function($masterObject, $detailObject, $objectItems){ 

                    //code here

                }, $this->criteria_fieldList_arquivos); 

                $this->form->setData($object); // fill the form 

                TTransaction::close(); // close the transaction 
            }
            else
            {
                $this->form->clear();
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }

    /**
     * Clear form data
     * @param $param Request
     */
    public function onClear( $param )
    {
        $this->form->clear(true);

        $this->fieldList_arquivos->addHeader();
        $this->fieldList_arquivos->addDetail($this->default_item_fieldList_arquivos);

        $this->fieldList_arquivos->addCloneAction(null, 'fas:plus #69aa46', "Clonar");

    }

    public function onShow($param = null)
    {
        $this->fieldList_arquivos->addHeader();
        $this->fieldList_arquivos->addDetail($this->default_item_fieldList_arquivos);

        $this->fieldList_arquivos->addCloneAction(null, 'fas:plus #69aa46', "Clonar");

    } 

    public static function getFormName()
    {
        return self::$formName;
    }

}

