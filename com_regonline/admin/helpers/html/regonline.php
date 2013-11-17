<?php
defined('_JEXEC') or die();

abstract class JHtmlRegonline 
{
    static public function courseOptions()
    {
    	$user = JFactory::getUser();
        $options   = array();
        
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        
        $query->select('a.id as value, a.title as text')
        	->from('#__regonline_courses AS a');

        // Implement View Level Access.
        if (!$user->authorise('core.admin')) {
            $groups = implode(',', $user->getAuthorisedViewLevels());
            $query->where('a.access IN (' . $groups . ')');
        }        	
        $db->setQuery($query);
        
        $items = $db->loadObjectList();
       	foreach($items AS $item)
        {
            // Create a new option object based on the <option /> element.
            $opt = JHtml::_('select.option', (string) $item->value,
                JText::alt(trim((string) $item->text),
                preg_replace('/[^a-zA-Z0-9_\-]/', '_', 'course_id')),
                'value',
                'text'
            );

            // Add the option object to the result set.
            $options[] = $opt;
        }
        
        return $options;
    }
	
    static public function scheduleOptions()
    {
    	$user = JFactory::getUser();
        $options   = array();
        
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        
        $query->select('a.id as value, a.title as text')
        	->from('#__regonline_schedules AS a');

        // Implement View Level Access.
        if (!$user->authorise('core.admin')) {
            $groups = implode(',', $user->getAuthorisedViewLevels());
            $query->where('a.access IN (' . $groups . ')');
        }        	
        $db->setQuery($query);
        
        $items = $db->loadObjectList();
       	foreach($items AS $item)
        {
            // Create a new option object based on the <option /> element.
            $opt = JHtml::_('select.option', (string) $item->value,
                JText::alt(trim((string) $item->text),
                preg_replace('/[^a-zA-Z0-9_\-]/', '_', 'schedule_id')),
                'value',
                'text'
            );

            // Add the option object to the result set.
            $options[] = $opt;
        }
        
        return $options;
    }    
}