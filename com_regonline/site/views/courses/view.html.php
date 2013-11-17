<?php
defined('_JEXEC') or die;
jimport('joomla.application.component.view');

/**
 * Courses view.
 *
 * @package     
 * @subpackage  
 * @since       1.0
 */
class RegonlineViewCourses extends JView
{
	
	function display() {

		$this->items = $this->get("Items");
		$this->state = $this->get("State");
		$this->pagination = $this->get("Pagination");
		parent::display();
	}
}