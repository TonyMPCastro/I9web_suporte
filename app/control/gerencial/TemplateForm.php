<?php

class TemplateForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'chamado';
    private static $activeRecord = 'Template';
    private static $primaryKey = 'id';
    private static $formName = 'form_TemplateForm';

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
        $this->form->setFormTitle("Cadastro de template");


        $chave = new TEntry('chave');
        $id = new TEntry('id');
        $titulo = new TEntry('titulo');
        $template = new THtmlEditor('template');

        $chave->addValidation("Chave", new TRequiredValidator()); 
        $titulo->addValidation("Título", new TRequiredValidator()); 
        $template->addValidation("Template", new TRequiredValidator()); 

        $id->setEditable(false);
        $chave->setEditable(false);

        $id->setSize(100);
        $chave->setSize('100%');
        $titulo->setSize('100%');
        $template->setSize('100%', 200);

        $row1 = $this->form->addFields([new TLabel("Chave:", '#ff0000', '14px', null, '100%'),$chave,$id]);
        $row1->layout = [' col-sm-12'];

        $row2 = $this->form->addFields([new TLabel("Variáveis disponíveis para chamados", null, '14px', 'B', '100%')],[new TLabel("<b>{\$id}</b> código do chamado", null, '12px', null, '100%'),new TLabel("<b>{\$categoria_nome}</b> código do chamado", null, '12px', null, '100%'),new TLabel("<b>{\$estado}</b> estado do chamado", null, '12px', null, '100%')],[new TLabel("<b>{\$solicitante}</b> nome do solicitante", null, '12px', null, '100%'),new TLabel("<b>{\$atendente}</b> nome do atendente", null, '12px', null, '100%'),new TLabel("<b>{\$dt_abertura}</b> data abertura", null, '12px', null, '100%'),new TLabel("<b>{\$dt_fechamento}</b> data fechamento", null, '12px', null, '100%')],[new TLabel("<b>{\$produto}</b> nome do produto", null, '12px', null, '100%'),new TLabel("<b>{\$observacao_abertura}</b> observação de abertura", null, '12px', null, '100%'),new TLabel("<b>{\$observacao_fechamento}</b> observação de fechamento", null, '12px', null, '100%')],[new TLabel("Variáveis disponíveis para notas", null, '14px', 'B', '100%')],[new TLabel("<b>{\$observacao_nota}</b> observação da nota", null, '14px', null, '100%'),new TLabel("<b>{\$dt_nota}</b> data da nota", null, '14px', null)]);
        $row2->layout = [' col-sm-12',' col-sm-4',' col-sm-4',' col-sm-4',' col-sm-12',' col-sm-4'];

        $row3 = $this->form->addFields([new TLabel("Título:", '#ff0000', '14px', null, '100%'),$titulo]);
        $row3->layout = [' col-sm-12'];

        $row4 = $this->form->addFields([new TLabel("Template:", '#ff0000', '14px', null, '100%'),$template]);
        $row4->layout = [' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
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

        $style = new TStyle('right-panel > .container-part[page-name=TemplateForm]');
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

            $object = new Template(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            new TMessage('info', "Registro salvo", $messageAction); 

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

                $object = new Template($key); // instantiates the Active Record 

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

