<?php
defined('_JEXEC') or die;
/**
 * Regonline display helper.
 *
 * @package     RegOnline
 * @subpackage  
 * @since       1.0
 */
class RegonlineHelper
{
	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return  JObject
	 * @since   1.6
	 */
	public static function getActions()
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action) {
			$result->set($action, $user->authorise($action, 'com_regonline'));
		}

		return $result;
	}
	
		/**
	 * Configure the Linkbar.
	 *
	 * @param   string  $vName  The name of the active view.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public static function addSubmenu($vName)
	{
		JSubMenuHelper::addEntry(
			JText::_('COM_Regonline_SUBMENU_courses'),
			'index.php?option=com_Regonline&view=courses',
			$vName == 'courses'
		);
		
		JSubMenuHelper::addEntry(
			JText::_('COM_regonline_SUBMENU_CATEGORIES'),
			'index.php?option=com_categories&extension=com_regonline',
			$vName == 'categories'
		);

		JSubMenuHelper::addEntry(
			JText::_('COM_REGONLINE_SUBMENU_SCHEDULES'),
			'index.php?option=com_regonline&view=schedules',
			$vName == 'schedules'
		);
		
		JSubMenuHelper::addEntry(
			JText::_('COM_regonline_SUBMENU_registrations'),
			'index.php?option=com_regonline&view=registrations',
			$vName == 'registrations'
		);
	}


}