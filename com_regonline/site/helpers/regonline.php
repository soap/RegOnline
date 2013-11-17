<?php
defined('_JEXEC') or die;
/**
 * Regonline display helper.
 *
 * @package     Registration Online
 * @subpackage  com_regonline
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
}