<?php
defined('_JEXEC') or die;
jimport('joomla.application.component.controllerform');

/**
 * Registrationform Subcontroller.
 *
 * @package     Registration Online
 * @subpackage  com_regonline
 * @since       1.0
 */
class RegonlineControllerRegistrationform extends JControllerForm
{
	protected $view_item = 'registrationform';
	
	protected $view_list = 'schedules';
	
	protected function getRedirectToItemAppend($recordId = null, $urlVar = 'id')
	{
		$append = parent::getRedirectToItemAppend($recordId, $urlVar);
		
		$task = $this->getTask();
		if ($task == 'add') { 
			$schedule_id = JRequest::getCmd('schedule_id', '');
			$append .= '&schedule_id='.$schedule_id;
		}
		
		return $append;
	}
}