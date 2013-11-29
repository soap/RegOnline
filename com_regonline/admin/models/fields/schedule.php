<?php
defined ('_JEXEC') or die;
jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

/**
 * Schedule Field class for RegOnline
 *
 * @package		RegOnline
 * @subpackage	
 * @since		1.0
 */
class JFormFieldSchedule extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Schedule';

	/**
	 * Method to get the field options.
	 *
	 * @return	array	The field option objects.
	 * @since	1.6
	 */
	public function getOptions()
	{
		// Initialize variables.
		$options = array();
        
		$user = JFactory::getUser();
        $access = implode( ',', $user->getAuthorisedViewLevels() );
        
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
        
		$query->select('id As value, title As text');
		$query->from('#__regonline_schedules AS a');
		
		//Super Admin can do anything
		if (!$user->authorise('core.admin')) {
			$query->where('a.access IN ('.$access.')');
		}
		$query->order('a.title');

		// Get the options.
		$db->setQuery($query);

		$options = $db->loadObjectList();

		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}
		
		// Merge any additional options in the XML definition.
		$options = array_merge(parent::getOptions(), $options);
		
		return $options;
	}
}
