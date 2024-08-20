<?php

class NovoChamadoForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'chamado';
    private static $activeRecord = 'Chamado';
    private static $primaryKey = 'id';
    private static $formName = 'form_ChamadoForm';

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
        $criteria_prioridade_id = new TCriteria();
        $criteria_categoria_id = new TCriteria();

        $filterVar = TSession::getValue('userid');
        $criteria_produto_id->add(new TFilter('id', 'in', "(SELECT produto_id FROM cliente_produto WHERE cliente_id in  (SELECT id FROM cliente WHERE system_user_id = '{$filterVar}') )")); 

        $solicitante_id = new TEntry('solicitante_id');
        $produto_id = new TDBCombo('produto_id', 'chamado', 'Produto', 'id', '{nome}','nome asc' , $criteria_produto_id );
        $prioridade_id = new TDBCombo('prioridade_id', 'chamado', 'Prioridade', 'id', '{nome}','ordem desc' , $criteria_prioridade_id );
        $categoria_id = new TDBCombo('categoria_id', 'chamado', 'Categoria', 'id', '{nome}','nome asc' , $criteria_categoria_id );
        $observacao_abertura = new TText('observacao_abertura');
        $arquivo_chamado_chamado_id = new THidden('arquivo_chamado_chamado_id[]');
        $arquivo_chamado_chamado___row__id = new THidden('arquivo_chamado_chamado___row__id[]');
        $arquivo_chamado_chamado___row__data = new THidden('arquivo_chamado_chamado___row__data[]');
        $arquivo_chamado_chamado_name = new TFile('arquivo_chamado_chamado_name[]');
        $this->fieldList_arquivos = new TFieldList();

        $this->fieldList_arquivos->addField(null, $arquivo_chamado_chamado_id, []);
        $this->fieldList_arquivos->addField(null, $arquivo_chamado_chamado___row__id, ['uniqid' => true]);
        $this->fieldList_arquivos->addField(null, $arquivo_chamado_chamado___row__data, []);
        $this->fieldList_arquivos->addField(new TLabel("Arquivo", null, '14px', null), $arquivo_chamado_chamado_name, ['width' => '100%']);

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

        $solicitante_id->addValidation("Cliente", new TRequiredValidator()); 
        $produto_id->addValidation("Produto", new TRequiredValidator()); 
        $prioridade_id->addValidation("Prioridade", new TRequiredValidator()); 
        $categoria_id->addValidation("Categoria", new TRequiredValidator()); 
        $observacao_abertura->addValidation("Observação", new TRequiredValidator()); 

        $solicitante_id->setEditable(false);
        $arquivo_chamado_chamado_name->enableFileHandling();
        $produto_id->setDefaultOption(false);
        $categoria_id->setDefaultOption(false);
        $prioridade_id->setDefaultOption(false);

        $produto_id->setSize('100%');
        $categoria_id->setSize('100%');
        $prioridade_id->setSize('100%');
        $solicitante_id->setSize('100%');
        $observacao_abertura->setSize('100%', 70);
        $arquivo_chamado_chamado_name->setSize('100%');

        $observacao_abertura->placeholder = "Descreva a situação";

        $row1 = $this->form->addFields([new TLabel("Cliente:", '#FF0000', '14px', null, '100%'),$solicitante_id],[new TLabel("Produto:", '#ff0000', '14px', null, '100%'),$produto_id]);
        $row1->layout = [' col-sm-6',' col-sm-6'];

        $row2 = $this->form->addFields([new TLabel("Prioridade:", '#ff0000', '14px', null, '100%'),$prioridade_id],[new TLabel("Categoria:", '#ff0000', '14px', null, '100%'),$categoria_id]);
        $row2->layout = ['col-sm-6',' col-sm-6'];

        $row3 = $this->form->addFields([new TLabel("Observação:", '#ff0000', '14px', null, '100%'),$observacao_abertura]);
        $row3->layout = [' col-sm-12'];

        $row4 = $this->form->addFields([$this->fieldList_arquivos]);
        $row4->layout = [' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave'],['static' => 1]), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);

        $style = new TStyle('right-panel > .container-part[page-name=NovoChamadoForm]');
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

            $estado = Status::where('ativo', '=', 'T')->where('estado_inicial', '=', 'T')->orderBy('id', 'desc')->first();

            $object->mes_abertura = date('m');
            $object->ano_abertura = date('Y');
            $object->anomes_abertura = date('Ym');

            if (! $estado)
            {
                throw new Exception('Estado inicial não definido! entre em contato com o administrador');
            }

            $object->status_id = $estado->id;

            $arquivo_chamado_chamado_name_dir = 'anexos';  

            $object->store(); // save the object 

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

            try
            {
                TTransaction::open('permission');
                $preferences = SystemPreference::getAllPreferences();
                TTransaction::close();

                if (! empty($preferences['mail_from']) && ! empty($preferences['smtp_user']) && ! empty($preferences['smtp_pass']) && ! empty($preferences['smtp_host']) && ! empty($preferences['smtp_port']))
                {
                    $template = Template::find(Template::EMAIL_ABERTURA_CHAMADO);
                    $arquivos = $object->getArquivoChamados();
                    $anexos = [];

                    if ($arquivos)
                    {
                        foreach($arquivos as $arquivo)
                        {
                            $anexos[] = [$arquivo->name];
                        }
                    }

                    MailService::send($object->categoria->email, $template->parserTitulo($object), $template->parserTemplate($object), 'html', $anexos);
                }
            }
            catch(Exception $e)
            {
                TToast::show('warning', 'E-mail de abertura não enviado: ' . $e->getMessage(), 'topRight');
            }

            TTransaction::close(); // close the transaction

            TToast::show('success', "Registro salvo", 'topRight', 'far:check-circle');
            TApplication::loadPage('MeusChamadoList', 'onShow', $loadPageParam); 

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

