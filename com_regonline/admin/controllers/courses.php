<?php
defined('_JEXEC') or die;
jimport('joomla.application.component.controlleradmin');

/**
 * Courses Subcontroller.
 *
 * @package     RegOnline
 * @subpackage  
 * @since       1.0
 */
class RegonlineControllerCourses extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 * 
	 * @param   string  $name    The name of the model.
	 * @param   string  $prefix  The prefix for the model class name.
	 * @param   string  $config  The model configuration array.
	 *
	 * @return  RegonlineModelCourses	The model for the controller set to ignore the request.
	 * @since   1.6
	 */
	public function getModel($name = 'Course', $prefix = 'RegonlineModel', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, $config);
	}
}