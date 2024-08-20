<?php

class StatusForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'chamado';
    private static $activeRecord = 'Status';
    private static $primaryKey = 'id';
    private static $formName = 'form_StatusForm';

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
        $this->form->setFormTitle("Cadastro de status");


        $id = new TEntry('id');
        $nome = new TEntry('nome');
        $cor = new TColor('cor');
        $estado_inicial = new TRadioGroup('estado_inicial');
        $estado_final = new TRadioGroup('estado_final');
        $ativo = new TRadioGroup('ativo');

        $nome->addValidation("Nome", new TRequiredValidator()); 
        $estado_inicial->addValidation("Estado inicial", new TRequiredValidator()); 
        $estado_final->addValidation("Estado final", new TRequiredValidator()); 
        $ativo->addValidation("Ativo", new TRequiredValidator()); 

        $id->setEditable(false);
        $ativo->addItems(["T"=>"Sim","F"=>"Não"]);
        $estado_final->addItems(["T"=>"Sim","F"=>"Não"]);
        $estado_inicial->addItems(["T"=>"Sim","F"=>"Não"]);

        $ativo->setLayout('horizontal');
        $estado_final->setLayout('horizontal');
        $estado_inicial->setLayout('horizontal');

        $ativo->setValue('T');
        $estado_final->setValue('F');
        $estado_inicial->setValue('F');

        $ativo->setUseButton();
        $estado_final->setUseButton();
        $estado_inicial->setUseButton();

        $id->setSize(100);
        $cor->setSize(110);
        $ativo->setSize(80);
        $nome->setSize('100%');
        $estado_final->setSize('100%');
        $estado_inicial->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null, '100%'),$id]);
        $row1->layout = ['col-sm-6'];

        $row2 = $this->form->addFields([new TLabel("Nome:", '#ff0000', '14px', null, '100%'),$nome],[new TLabel("Cor:", '#FF0000', '14px', null, '100%'),$cor]);
        $row2->layout = [' col-sm-8',' col-sm-4'];

        $row3 = $this->form->addFields([new TLabel("Estado inicial:", '#ff0000', '14px', null, '100%'),$estado_inicial],[new TLabel("Estado final:", '#ff0000', '14px', null, '100%'),$estado_final],[new TLabel("Ativo:", '#FF0000', '14px', null, '100%'),$ativo]);
        $row3->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['StatusHeaderList', 'onShow']), 'fas:arrow-left #000000');
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

    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new Status(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

            $loadPageParam = [];

            if(!empty($param['target_container']))
            {
                $loadPageParam['target_container'] = $param['target_container'];
            }

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            TToast::show('success', "Registro salvo", 'topRight', 'far:check-circle');
            TApplication::loadPage('StatusHeaderList', 'onShow', $loadPageParam); 

                        TScript::create("Template.closeRightPanel();"); 
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

                $object = new Status($key); // instantiates the Active Record 

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

    }

    public function onShow($param = null)
    {

    } 

    public static function getFormName()
    {
        return self::$formName;
    }

}

