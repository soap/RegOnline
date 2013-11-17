<?php
defined('_JEXEC') or die;
jimport('joomla.application.component.view');

/**
 * Schedules view.
 *
 * @package     RegOnline
 * @subpackage  
 * @since       1.0
 */
class RegonlineViewSchedules extends JViewLegacy
{
	protected $items;
	protected $state;
	protected $pagination;
	protected $menu; 
	
	public function display() {
		
		$this->items 		= $this->get("Items");
		$this->state 		= $this->get("State");
		$this->pagination 	= $this->get("Pagination");
		$this->menu			= new BSMenuContext();
		
		$this->toolbar 		= $this->getToolbar();
		
		parent::display();		
	}	
	
	public function getToolbar()
	{
		$items = array();
        $items[] = array('text' => 'COM_REGONLINE_ACTION_REGISTER',
        			'task' => 'schedule.register');
        //BSToolbar::renderButton($items);
        BSToolbar::button('COM_REGONLINE_ACTION_REGISTER', 
        	'registration.add', false, array('class'=>'btn-mini'));
        
        return BSToolbar::render();
	}
}