<?php
defined('_JEXEC') or die;
jimport('joomla.application.component.controller');

/**
 * Regonline Component Controller
 *
 * @package     RegOnline
 * @subpackage  
 * @since       1.0
 */
class RegonlineController extends JController
{
	/**
	 * @var    string  The default view.
	 * @since  1.0
	 */
	protected $default_view = 'courses';

	/**
	 * Override the display method for the controller.
	 *
	 * @return  void
	 * @since   1.0
	 */
	function display()
	{
		// Load the component helper.
		require_once JPATH_COMPONENT.'/helpers/regonline.php';
		// Load the submenu.
		$view = JFactory::getApplication()->input->get('view', $this->default_view, 'CMD');
		RegonlineHelper::addSubmenu($view);

		// Display the view.
		parent::display();
	}	
}