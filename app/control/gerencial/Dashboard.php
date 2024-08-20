<?php

class Dashboard extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_Dashboard';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param = null)
    {
        parent::__construct();

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("Dashboard");

        $criteria_cliente_id = new TCriteria();
        $criteria_total_aberto = new TCriteria();
        $criteria_fechados = new TCriteria();
        $criteria_top_atendentes = new TCriteria();
        $criteria_pro_cliente = new TCriteria();
        $criteria_abertos = new TCriteria();
        $criteria_chamados_por_prioridade = new TCriteria();
        $criteria_chamado_por_categoria = new TCriteria();
        $criteria_por_tipo_problema = new TCriteria();
        $criteria_chamado_por_abertura = new TCriteria();
        $criteria_fechados_por_data = new TCriteria();

        $filterVar = NULL;
        $criteria_total_aberto->add(new TFilter('chamado.dt_fechamento', 'is', $filterVar)); 
        $filterVar = NULL;
        $criteria_fechados->add(new TFilter('chamado.dt_fechamento', 'is not', $filterVar)); 
        $filterVar = NULL;
        $criteria_top_atendentes->add(new TFilter('chamado.dt_fechamento', 'is', $filterVar)); 
        $filterVar = NULL;
        $criteria_fechados_por_data->add(new TFilter('chamado.dt_fechamento', 'is not', $filterVar)); 

        $criteria_top_atendentes->setProperty('limit', '10');

        $cliente_id = new TDBCombo('cliente_id', 'chamado', 'Cliente', 'id', '{system_user_id}','id asc' , $criteria_cliente_id );
        $de = new TDate('de');
        $ate = new TDate('ate');
        $button_filtrar = new TButton('button_filtrar');
        $total_aberto = new BIndicator('total_aberto');
        $fechados = new BIndicator('fechados');
        $top_atendentes = new BTableChart('top_atendentes');
        $pro_cliente = new BBarChart('pro_cliente');
        $abertos = new BBarChart('abertos');
        $chamados_por_prioridade = new BPieChart('chamados_por_prioridade');
        $chamado_por_categoria = new BDonutChart('chamado_por_categoria');
        $por_tipo_problema = new BPieChart('por_tipo_problema');
        $chamado_por_abertura = new BLineChart('chamado_por_abertura');
        $fechados_por_data = new BLineChart('fechados_por_data');


        $cliente_id->enableSearch();
        $button_filtrar->setAction(new TAction([$this, 'onSearch']), "Filtrar");
        $button_filtrar->addStyleClass('btn-default');
        $button_filtrar->setImage('fas:search #000000');
        $de->setMask('dd/mm/yyyy');
        $ate->setMask('dd/mm/yyyy');

        $de->setDatabaseMask('yyyy-mm-dd');
        $ate->setDatabaseMask('yyyy-mm-dd');

        $de->setSize(110);
        $ate->setSize(110);
        $cliente_id->setSize('100%');

        $total_aberto->setDatabase('chamado');
        $total_aberto->setFieldValue("chamado.id");
        $total_aberto->setModel('Chamado');
        $total_aberto->setTotal('count');
        $total_aberto->setColors('#27ae60', '#ffffff', '#2ecc71', '#ffffff');
        $total_aberto->setTitle("ABERTOS", '#ffffff', '24', '');
        $total_aberto->setCriteria($criteria_total_aberto);
        $total_aberto->setIcon(new TImage('fas:unlock #ffffff'));
        $total_aberto->setValueSize("28");
        $total_aberto->setValueColor("#ffffff", 'B');
        $total_aberto->setSize('100%', 95);
        $total_aberto->setLayout('horizontal', 'left');

        $fechados->setDatabase('chamado');
        $fechados->setFieldValue("chamado.id");
        $fechados->setModel('Chamado');
        $fechados->setTotal('count');
        $fechados->setColors('#E74C3C', '#ffffff', '#C0392B', '#ffffff');
        $fechados->setTitle("Finalizados", '#ffffff', '23', '');
        $fechados->setCriteria($criteria_fechados);
        $fechados->setIcon(new TImage('fas:lock #ffffff'));
        $fechados->setValueSize("27");
        $fechados->setValueColor("#ffffff", 'B');
        $fechados->setSize('100%', 95);
        $fechados->setLayout('horizontal', 'left');

        $top_atendentes_column_atendente_id = new BTableColumnChart('atendente.id', "Atendente", 'left','80%');
        $top_atendentes_column_id = new BTableColumnChart('id', "Total", 'center','20%');
        $top_atendentes_column_id->setTotal('sum');
        $top_atendentes_column_id->setAggregate('count');

        $top_atendentes->setDatabase('chamado');
        $top_atendentes->setModel('Chamado');
        $top_atendentes->setTitle("Top 10 atendentes com chamados abertos");
        $top_atendentes->setSize('100%', 280);
        $top_atendentes->setColumns([$top_atendentes_column_atendente_id,$top_atendentes_column_id]);
        $top_atendentes->setCriteria($criteria_top_atendentes);
        $top_atendentes->setJoins([
             'atendente' => ['chamado.atendente_id', 'atendente.id']
        ]);

        $top_atendentes->setRowColorOdd('#F9F9F9');
        $top_atendentes->setRowColorEven('#FFFFFF');
        $top_atendentes->setFontRowColorOdd('#333333');
        $top_atendentes->setFontRowColorEven('#333333');
        $top_atendentes->setBorderColor('#DDDDDD');
        $top_atendentes->setTableHeaderColor('#FFFFFF');
        $top_atendentes->setTableHeaderFontColor('#333333');
        $top_atendentes->setTableFooterColor('#FFFFFF');
        $top_atendentes->setTableFooterFontColor('#333333');

        $pro_cliente->setDatabase('chamado');
        $pro_cliente->setFieldValue("chamado.id");
        $pro_cliente->setFieldGroup(["cliente.id"]);
        $pro_cliente->setModel('Chamado');
        $pro_cliente->setTitle("Top clientes");
        $pro_cliente->setLayout('vertical');
        $pro_cliente->setJoins([
             'cliente' => ['chamado.solicitante_id', 'cliente.id']
        ]);
        $pro_cliente->setTotal('count');
        $pro_cliente->showLegend(true);
        $pro_cliente->enableOrderByValue('desc');
        $pro_cliente->setCriteria($criteria_pro_cliente);
        $pro_cliente->setLabelValue("Quantidade");
        $pro_cliente->setSize('100%', 280);
        $pro_cliente->disableZoom();

        $abertos->setDatabase('chamado');
        $abertos->setFieldValue("chamado.id");
        $abertos->setFieldGroup(["produto.nome"]);
        $abertos->setModel('Chamado');
        $abertos->setTitle("Top produtos");
        $abertos->setLayout('vertical');
        $abertos->setJoins([
             'produto' => ['chamado.produto_id', 'produto.id']
        ]);
        $abertos->setTotal('count');
        $abertos->showLegend(true);
        $abertos->enableOrderByValue('desc');
        $abertos->setCriteria($criteria_abertos);
        $abertos->setLabelValue("Quantidade");
        $abertos->setSize('100%', 280);
        $abertos->disableZoom();

        $chamados_por_prioridade->setDatabase('chamado');
        $chamados_por_prioridade->setFieldValue("chamado.id");
        $chamados_por_prioridade->setFieldGroup("prioridade.nome");
        $chamados_por_prioridade->setModel('Chamado');
        $chamados_por_prioridade->setTitle("Por prioridade");
        $chamados_por_prioridade->setJoins([
             'prioridade' => ['chamado.prioridade_id', 'prioridade.id']
        ]);
        $chamados_por_prioridade->setTotal('count');
        $chamados_por_prioridade->showLegend(true);
        $chamados_por_prioridade->enableOrderByValue('asc');
        $chamados_por_prioridade->setCriteria($criteria_chamados_por_prioridade);
        $chamados_por_prioridade->setSize('100%', 280);
        $chamados_por_prioridade->disableZoom();

        $chamado_por_categoria->setDatabase('chamado');
        $chamado_por_categoria->setFieldValue("chamado.id");
        $chamado_por_categoria->setFieldGroup("categoria.nome");
        $chamado_por_categoria->setModel('Chamado');
        $chamado_por_categoria->setTitle("Por categoria");
        $chamado_por_categoria->setJoins([
             'categoria' => ['chamado.categoria_id', 'categoria.id']
        ]);
        $chamado_por_categoria->setTotal('count');
        $chamado_por_categoria->showLegend(true);
        $chamado_por_categoria->enableOrderByValue('asc');
        $chamado_por_categoria->setCriteria($criteria_chamado_por_categoria);
        $chamado_por_categoria->setSize('100%', 280);
        $chamado_por_categoria->disableZoom();

        $por_tipo_problema->setDatabase('chamado');
        $por_tipo_problema->setFieldValue("chamado.id");
        $por_tipo_problema->setFieldGroup("tipo_problema.nome");
        $por_tipo_problema->setModel('Chamado');
        $por_tipo_problema->setTitle("Por tipo problema");
        $por_tipo_problema->setJoins([
             'tipo_problema' => ['chamado.tipo_problema_id', 'tipo_problema.id']
        ]);
        $por_tipo_problema->setTotal('count');
        $por_tipo_problema->showLegend(true);
        $por_tipo_problema->enableOrderByValue('asc');
        $por_tipo_problema->setCriteria($criteria_por_tipo_problema);
        $por_tipo_problema->setSize('100%', 280);
        $por_tipo_problema->disableZoom();

        $chamado_por_abertura->setDatabase('chamado');
        $chamado_por_abertura->setFieldValue("chamado.id");
        $chamado_por_abertura->setFieldGroup(["chamado.anomes_abertura"]);
        $chamado_por_abertura->setModel('Chamado');
        $chamado_por_abertura->setTitle("Abertos por mês");
        $chamado_por_abertura->setTransformerLegend(function($value, $row, $data)
            {
                if (empty($value))
                {
                    return '';
                }

                $meses = [
                    1 => 'jan',
                    2 => 'fev',
                    3 => 'mar',
                    4 => 'abr',
                    5 => 'mai',
                    6 => 'jun',
                    7 => 'jul',
                    8 => 'ago',
                    9 => 'set',
                    10 => 'out',
                    11 => 'nov',
                    12 => 'dez',
                ];

                return $meses[(int)substr($value, 4, 2)] . '/' . substr($value,2, 2);

            });
        $chamado_por_abertura->setTotal('count');
        $chamado_por_abertura->showLegend(true);
        $chamado_por_abertura->setCriteria($criteria_chamado_por_abertura);
        $chamado_por_abertura->setLabelValue("Quantidade");
        $chamado_por_abertura->setSize('100%', 280);

        $fechados_por_data->setDatabase('chamado');
        $fechados_por_data->setFieldValue("chamado.id");
        $fechados_por_data->setFieldGroup(["chamado.anomes_fechamento"]);
        $fechados_por_data->setModel('Chamado');
        $fechados_por_data->setTitle("Fechados por mês");
        $fechados_por_data->setTransformerLegend(function($value, $row, $data)
            {
                if (empty($value))
                {
                    return '';
                }

                $meses = [
                    1 => 'jan',
                    2 => 'fev',
                    3 => 'mar',
                    4 => 'abr',
                    5 => 'mai',
                    6 => 'jun',
                    7 => 'jul',
                    8 => 'ago',
                    9 => 'set',
                    10 => 'out',
                    11 => 'nov',
                    12 => 'dez',
                ];

                return $meses[(int)substr($value, 4, 2)] . '/' . substr($value,2, 2);

            });
        $fechados_por_data->setTotal('count');
        $fechados_por_data->showLegend(true);
        $fechados_por_data->setCriteria($criteria_fechados_por_data);
        $fechados_por_data->setLabelValue("Quantidade");
        $fechados_por_data->setSize('100%', 280);

        $row1 = $this->form->addFields([new TLabel("Cliente:", null, '14px', null, '100%'),$cliente_id],[new TLabel("Período:", null, '14px', null, '100%'),$de,new TLabel("até", null, '14px', null),$ate,$button_filtrar]);
        $row1->layout = [' col-sm-6','col-sm-6'];

        $row2 = $this->form->addFields([$total_aberto],[$fechados]);
        $row2->layout = [' col-sm-6','col-sm-6'];

        $row3 = $this->form->addFields([$top_atendentes]);
        $row3->layout = [' col-sm-12'];

        $row4 = $this->form->addFields([$pro_cliente],[$abertos]);
        $row4->layout = [' col-sm-6',' col-sm-6'];

        $row5 = $this->form->addFields([$chamados_por_prioridade],[$chamado_por_categoria],[$por_tipo_problema]);
        $row5->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row6 = $this->form->addFields([$chamado_por_abertura],[$fechados_por_data]);
        $row6->layout = [' col-sm-6',' col-sm-6'];

        $searchData = $this->form->getData();
        $this->form->setData($searchData);

        $filterVar = $searchData->cliente_id;
        if($filterVar)
        {
            $criteria_total_aberto->add(new TFilter('chamado.solicitante_id', '=', $filterVar)); 
        }
        $filterVar = $searchData->de;
        if($filterVar)
        {
            $criteria_total_aberto->add(new TFilter('chamado.dt_abertura', '>=', $filterVar)); 
        }
        $filterVar = $searchData->ate;
        if($filterVar)
        {
            $criteria_total_aberto->add(new TFilter('chamado.dt_abertura', '<=', $filterVar)); 
        }
        $filterVar = $searchData->de;
        if($filterVar)
        {
            $criteria_fechados->add(new TFilter('chamado.dt_fechamento', '>=', $filterVar)); 
        }
        $filterVar = $searchData->ate;
        if($filterVar)
        {
            $criteria_fechados->add(new TFilter('chamado.dt_fechamento', '<=', $filterVar)); 
        }
        $filterVar = $searchData->cliente_id;
        if($filterVar)
        {
            $criteria_fechados->add(new TFilter('chamado.solicitante_id', '=', $filterVar)); 
        }
        $filterVar = $searchData->cliente_id;
        if($filterVar)
        {
            $criteria_top_atendentes->add(new TFilter('chamado.solicitante_id', '=', $filterVar)); 
        }
        $filterVar = $searchData->de;
        if($filterVar)
        {
            $criteria_top_atendentes->add(new TFilter('chamado.dt_abertura', '>=', $filterVar)); 
        }
        $filterVar = $searchData->ate;
        if($filterVar)
        {
            $criteria_top_atendentes->add(new TFilter('chamado.dt_abertura', '<=', $filterVar)); 
        }
        $filterVar = $searchData->cliente_id;
        if($filterVar)
        {
            $criteria_pro_cliente->add(new TFilter('chamado.solicitante_id', '=', $filterVar)); 
        }
        $filterVar = $searchData->de;
        if($filterVar)
        {
            $criteria_pro_cliente->add(new TFilter('chamado.dt_abertura', '>=', $filterVar)); 
        }
        $filterVar = $searchData->ate;
        if($filterVar)
        {
            $criteria_pro_cliente->add(new TFilter('chamado.dt_abertura', '<=', $filterVar)); 
        }
        $filterVar = $searchData->cliente_id;
        if($filterVar)
        {
            $criteria_abertos->add(new TFilter('chamado.solicitante_id', '=', $filterVar)); 
        }
        $filterVar = $searchData->de;
        if($filterVar)
        {
            $criteria_abertos->add(new TFilter('chamado.dt_abertura', '>=', $filterVar)); 
        }
        $filterVar = $searchData->ate;
        if($filterVar)
        {
            $criteria_abertos->add(new TFilter('chamado.dt_abertura', '<=', $filterVar)); 
        }
        $filterVar = $searchData->de;
        if($filterVar)
        {
            $criteria_chamados_por_prioridade->add(new TFilter('chamado.dt_abertura', '>=', $filterVar)); 
        }
        $filterVar = $searchData->ate;
        if($filterVar)
        {
            $criteria_chamados_por_prioridade->add(new TFilter('chamado.dt_abertura', '<=', $filterVar)); 
        }
        $filterVar = $searchData->cliente_id;
        if($filterVar)
        {
            $criteria_chamados_por_prioridade->add(new TFilter('chamado.solicitante_id', '=', $filterVar)); 
        }
        $filterVar = $searchData->cliente_id;
        if($filterVar)
        {
            $criteria_chamado_por_categoria->add(new TFilter('chamado.solicitante_id', '=', $filterVar)); 
        }
        $filterVar = $searchData->de;
        if($filterVar)
        {
            $criteria_chamado_por_categoria->add(new TFilter('chamado.dt_abertura', '>=', $filterVar)); 
        }
        $filterVar = $searchData->ate;
        if($filterVar)
        {
            $criteria_chamado_por_categoria->add(new TFilter('chamado.dt_abertura', '<=', $filterVar)); 
        }
        $filterVar = $searchData->cliente_id;
        if($filterVar)
        {
            $criteria_por_tipo_problema->add(new TFilter('chamado.solicitante_id', '=', $filterVar)); 
        }
        $filterVar = $searchData->de;
        if($filterVar)
        {
            $criteria_por_tipo_problema->add(new TFilter('chamado.dt_abertura', '>=', $filterVar)); 
        }
        $filterVar = $searchData->ate;
        if($filterVar)
        {
            $criteria_por_tipo_problema->add(new TFilter('chamado.dt_abertura', '<=', $filterVar)); 
        }
        $filterVar = $searchData->cliente_id;
        if($filterVar)
        {
            $criteria_chamado_por_abertura->add(new TFilter('chamado.solicitante_id', '=', $filterVar)); 
        }
        $filterVar = $searchData->de;
        if($filterVar)
        {
            $criteria_chamado_por_abertura->add(new TFilter('chamado.dt_abertura', '>=', $filterVar)); 
        }
        $filterVar = $searchData->ate;
        if($filterVar)
        {
            $criteria_chamado_por_abertura->add(new TFilter('chamado.dt_abertura', '<=', $filterVar)); 
        }
        $filterVar = $searchData->de;
        if($filterVar)
        {
            $criteria_fechados_por_data->add(new TFilter('chamado.dt_fechamento', '>=', $filterVar)); 
        }
        $filterVar = $searchData->ate;
        if($filterVar)
        {
            $criteria_fechados_por_data->add(new TFilter('chamado.dt_fechamento', '<=', $filterVar)); 
        }
        $filterVar = $searchData->cliente_id;
        if($filterVar)
        {
            $criteria_fechados_por_data->add(new TFilter('chamado.solicitante_id', '=', $filterVar)); 
        }

        BChart::generate($total_aberto, $fechados, $top_atendentes, $pro_cliente, $abertos, $chamados_por_prioridade, $chamado_por_categoria, $por_tipo_problema, $chamado_por_abertura, $fechados_por_data);

        // create the form actions

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Gerencial","Dashboard"]));
        }
        $container->add($this->form);

        $data = TSession::getValue(__CLASS__.'formData');

        $this->form->setData($data);

        parent::add($container);

    }

    public  function onSearch($param = null) 
    {
        try 
        {
            $data = $this->form->getData();

            TSession::setValue(__CLASS__.'formData', $data);

            $this->form->setData($data);

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public function onShow($param = null)
    {               

    } 

}

