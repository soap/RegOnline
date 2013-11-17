<?php
defined('_JEXEC') or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

/**
 * Course Field class for Registration Online
 *
 * @package		Registration Online
 * @subpackage	com_regonline
 * @since		1.0
 */
class JFormFieldCourse extends JFormFieldList
{
	protected $type = 'Course';
	
	public function getOptions()
	{
    	$options = array();
        $user    = JFactory::getUser();
        $db      = JFactory::getDbo();
        $query   = $db->getQuery(true);

        $site   = $this->site;

        // Get field attributes for the database query
        $state = ($this->element['state']) ? (int) $this->element['state'] : NULL;

        // Build the query
        $query->select('a.id AS value, a.title as text')
              ->from('#__regonline_courses AS a');
           
        // Implement View Level Access.
        if (!$user->authorise('core.admin')) {
            $groups = implode(',', $user->getAuthorisedViewLevels());
            $query->where('a.access IN (' . $groups . ')');
        }

        // Filter by state
        if (!is_null($state)) $query->where('a.state = ' . $db->quote($state));

        $query->order('a.title');

        $db->setQuery((string) $query);
        $items = (array) $db->loadObjectList();
        
        foreach($items AS $item)
        {
            // Create a new option object based on the <option /> element.
            $opt = JHtml::_('select.option', (string) $item->value,
                JText::alt(trim((string) $item->text), preg_replace('/[^a-zA-Z0-9_\-]/', '_', $this->fieldname)),
                'value',
                'text'
            );

            // Add the option object to the result set.
            $options[] = $opt;
        }

		$extras = (array) parent::getOptions();
		
		$options = array_merge($options, $extras);
		
        reset($options);
        
        return $options;
	}
}