<?php
defined('_JEXEC') or die;
jimport('joomla.application.component.view');

/**
 *  View Class for Regonline component
 *
 */
class RegonlineViewRegistrationform extends JViewLegacy
{
    protected $form;
    protected $item;
    protected $return_page;
    protected $state;
    protected $pageclass_sfx;
    protected $toolbar;


    public function display($tpl = null)
    {
        // Initialise variables.
        $app    = JFactory::getApplication();
        $user   = JFactory::getUser();

        // Get model data.
        $this->state       = $this->get('State');
        $this->item        = $this->get('Item');
        $this->form        = $this->get('Form');
        $this->return_page = $this->get('ReturnPage');
        $this->toolbar     = $this->getToolbar();

        // Permission check.
        if ($this->item->id <= 0) {
            $access = RegonlineHelper::getActions();
            $authorised = $access->get('core.create');
        }
        else {
        	if (isset($this->item->params) && is_object($this->item->params)) { 
            	$authorised = $this->item->params->get('access-edit');
        	}else{
        		$access = RegonlineHelper::getActions();
            	$authorised = $access->get('core.create');
        	}
        }

        if ($authorised !== true) {
            JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));
            return false;
        }

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            JError::raiseWarning(500, implode("\n", $errors));
            return false;
        }

        //Escape strings for HTML output
        $this->pageclass_sfx = htmlspecialchars($this->state->params->get('pageclass_sfx'));

        $this->params = $this->state->params;
        $this->user   = $user;

        // Prepare the document
        $this->_prepareDocument();

        // Display the view
        parent::display($tpl);
        
    }


    /**
     * Prepares the document
     *
     */
    protected function _prepareDocument()
    {
        $app     = JFactory::getApplication();
        $menu    = $app->getMenu()->getActive();
        $pathway = $app->getPathway();
        $title   = null;

        $def_title = JText::_('COM_REGONLINE_PAGE_' . ($this->item->id > 0 ? 'EDIT' : 'ADD') . '_Registrationform');

        // Because the application sets a default page title, we need to get it from the menu item itself
        if ($menu) {
        	$this->params->def('page_heading', $this->params->get('page_title', $menu->title));
        }
        else {
            $this->params->def('page_heading', $def_title);
        }

        $title = $this->params->def('page_title', $def_title);

        if ($app->getCfg('sitename_pagetitles', 0) == 1) {
            $title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
        }
        elseif ($app->getCfg('sitename_pagetitles', 0) == 2) {
            $title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
        }

        $this->document->setTitle($title);

        $pathway = $app->getPathWay();
        $pathway->addItem($title, '');

        if ($this->params->get('menu-meta_description')) {
            $this->document->setDescription($this->params->get('menu-meta_description'));
        }

        if ($this->params->get('menu-meta_keywords')) {
            $this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
        }

        if ($this->params->get('robots')) {
            $this->document->setMetadata('robots', $this->params->get('robots'));
        }
        
    }


    /**
     * Generates the toolbar for the top of the view
     *
     * @return    string    Toolbar with buttons
     */
    protected function getToolbar()
    {
        $options = array();
        $user    = JFactory::getUser();

       $options[] = array(
            'text' => 'COM_REGONLINE_SAVE',
            'task' => $this->getName() . '.apply');
       
        $options[] = array(
            'text' => 'COM_REGONLINE_SAVE_AND_CLOSE',
            'task' => $this->getName() . '.save');

        /* $options[] = array(
            'text' => 'COM_REGONLINE_ACTION_2NEW',
            'task' => $this->getName() . '.save2new');

        $options[] = array(
            'text' => 'COM_REGONLINE_ACTION_2COPY',
            'task' => $this->getName() . '.save2copy',
            'options' => array('access' => ($this->item->id > 0)));
		*/

        BSToolbar::dropdownButton($options, array('icon' => 'icon-white icon-ok'));

        BSToolbar::button(
            'JCANCEL',
            $this->getName() . '.cancel',
            false,
            array('class' => '', 'icon' => '')
        );

        return BSToolbar::render();
    }
}