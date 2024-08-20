<?php

class NotaForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'chamado';
    private static $activeRecord = 'Nota';
    private static $primaryKey = 'id';
    private static $formName = 'form_NotaForm';

    use Adianti\Base\AdiantiFileSaveTrait;

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
        $this->form->setFormTitle("Nova nota");


        $observacao = new TText('observacao');
        $anexo = new TFile('anexo');
        $chamado_id = new THidden('chamado_id');
        $origem = new THidden('origem');

        $observacao->addValidation("Observação", new TRequiredValidator()); 

        $anexo->enableFileHandling();
        $origem->setValue($param['origem']??'');
        $chamado_id->setValue($param['chamado_id']??null);

        $origem->setSize(200);
        $anexo->setSize('100%');
        $chamado_id->setSize(200);
        $observacao->setSize('100%', 100);

        $row1 = $this->form->addFields([new TLabel("Observação:", '#ff0000', '14px', null, '100%'),$observacao]);
        $row1->layout = [' col-sm-12'];

        $row2 = $this->form->addFields([new TLabel("Anexo:", null, '14px', null, '100%'),$anexo,$chamado_id,$origem]);
        $row2->layout = [' col-sm-12'];

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

        $style = new TStyle('right-panel > .container-part[page-name=NotaForm]');
        $style->width = '50% !important';   
        $style->show(true);

    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new Nota(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $userid = TSession::getValue('userid');

            if ($object->chamado->solicitante->system_user_id == $userid)
            {
                $object->cliente_id = $object->chamado->solicitante->id;
            }
            else
            {
                $atendente = Atendente::where('system_user_id', '=', $userid)->first();

                if (empty($atendente))
                {
                    throw new Exception('Você não é um atendente');
                }

                $object->atendente_id = $atendente->id;
            }

            if (empty($object->cliente_id) && empty($object->atendente_id))
            {
                throw new Exception('Informe o cliente ou antendente');
            }

            if ($object->chamado->solicitante->system_user_id == TSession::getValue('userid'))
            {
                $user = $object->chamado->atendente->system_user;
                $user_id = $object->chamado->atendente->system_user_id;
            }
            else
            {
                 $user = $object->chamado->solicitante->system_user;
                 $user_id = $object->chamado->solicitante->system_user_id;
            }

            $template = Template::find(Template::NOTIFICACAO_NOVA_NOTA);

            if (trim(strip_tags($template->template)) && $user_id)
            {
                $notificationParam = ['key' => $object->chamado_id, 'id' => $object->chamado_id];
                $icon = 'far fa-bell';
                SystemNotification::register( $user_id, $template->parserTitulo($object->chamado, $object), $template->parserTemplate($object->chamado, $object), new TAction(['ChamadoFormView', 'onShow'], $notificationParam), 'Abrir chamado #'.$object->chamado_id, $icon);
            }

            $preferences = SystemPreference::getAllPreferences();

            if ($user->email && ! empty($preferences['mail_from']) && ! empty($preferences['smtp_user']) && ! empty($preferences['smtp_pass']) && ! empty($preferences['smtp_host']) && ! empty($preferences['smtp_port']))
            {
                $template = Template::find(Template::EMAIL_NOVA_NOTA);

                $anexos = [];

                if ($object->anexo)
                {
                    $anexos[] = [$object->anexo];
                }

                MailService::send($user->email, $template->parserTitulo($object->chamado, $object), $template->parserTemplate($object->chamado, $object), 'html', $anexos);
            }

            $anexo_dir = 'nota_anexo';  

            $object->store(); // save the object 

            $this->saveFile($object, $data, 'anexo', $anexo_dir); 

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            new TMessage('info', "Registro salvo", $messageAction); 

            if ($data->origem && $data->origem == 'view')
            {
                TApplication::loadPage('ChamadoFormView', 'onShow', ['key' => $object->chamado_id, 'id' => $object->chamado_id]);
            }
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

                $object = new Nota($key); // instantiates the Active Record 

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

    public function onShowView($param)
    {
        $data = new stdClass;
        $data->origem = 'view';
        $this->form->setData($data);
    }

}

