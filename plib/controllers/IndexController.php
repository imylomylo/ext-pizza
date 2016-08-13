<?php

// Copyright 1999-2016. Parallels IP Holdings GmbH.

class IndexController extends pm_Controller_Action
{
	protected $_accessLevel = 'admin';

	public function init()
	{
		parent::init();

		// Init title for all actions
		$this->view->pageTitle = $this->lmsg('page_title');
	}

	public function indexAction()
	{
		// Default action is formAction
		$this->_forward('form');
	}

	public function formAction()
	{
		// Set the description text
		$this->view->output_description = $this->lmsg('page_title_description');

		// Init form here
		$form = new pm_Form_Simple();
		$form->addElement('text', 'pizzalink', ['label' => $this->lmsg('form_pizzalink'), 'value' => pm_Settings::get('pizzalink'), 'style' => 'width: 40%;']);
		$form->addControlButtons(['cancelLink' => pm_Context::getModulesListUrl(),]);

		// Process the form - save the license key and run the installation scripts
		if($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost()))
		{
			if($form->getValue('pizzalink'))
			{
				$pizza_link = $form->getValue('pizzalink');
			}
			else
			{
				$pizza_link = 'http://www.deliveryhero.com/';
			}

			pm_Settings::set('pizzalink', $pizza_link);

			$this->_status->addMessage('info', $this->lmsg('message_success'));
			$this->_helper->json(['redirect' => pm_Context::getBaseUrl()]);
		}

		$this->view->form = $form;
	}
}
