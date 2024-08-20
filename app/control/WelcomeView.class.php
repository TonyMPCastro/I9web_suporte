<?php
/**
 * WelcomeView
 *
 * @version    1.0
 * @package    control
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class WelcomeView extends TPage
{
    /**
     * Class constructor
     * Creates the page
     */
    function __construct()
    {
        parent::__construct();
        
        $iframe = new TElement('iframe');
        $iframe->border = 0;
        $iframe->style = 'width: 100%; height: 800px;';
        $iframe->src = 'https://madbuilder.com.br/apps-chamados';
        
        $h3 = new TElement('h3');
        $h3->add('Chamados');
        
        $h6 = new TElement('h6');
        $h6->add('Instruções para a utilizção do sistema de chamado');
        $h6->style = 'border-bottom: 1px solid #dfe4ed; width: 100%;padding-bottom: 10px; margin-bottom: 10px;';
        
        $form = new BootstrapFormBuilder;
        $form->addFields([$h3]);
        $form->addFields([$h6]);
        $form->addFields([$iframe]);
       
        parent::add( $form );
    }
}
