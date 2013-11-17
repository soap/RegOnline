<?php
defined('_JEXEC') or die;
jimport('joomla.application.component.modellist');

/**
 * Schedules model.
 *
 * @package     RegOnline
 * @subpackage  
 * @since       1.0
 */
class RegonlineModelSchedules extends JModelList
{
	/**
	 * Constructor override.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 *
	 * @return  ModelSchedules
	 * @since   1.0
	 * @see     JModelList
	 */

	public function __construct($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'id', 'a.id',
				'title', 'a.title',
				'alias', 'a.alias',
				'checked_out', 'a.checked_out',
				'a.start_date', 'a.apply_up',
				'a.min_applicants', 'a.max_applicants',
				'checked_out_time', 'a.checked_out_time',
				'a.course_id', 'course_title',
				'published', 'a.published',
				'access', 'a.access', 'access_level',
				'ordering', 'a.ordering',
				'language', 'a.language',
				'created', 'a.created',
				'created_by', 'a.created_by',
				'modified', 'a.modified',
				'modified_by', 'a.modified_by',
			);
		}
		parent::__construct($config);
	}
	
	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 
	 * @param   string  $ordering   An optional ordering field.
	 * @param   string  $direction  An optional direction (asc|desc).
	 *
	 * @return  void
	 * @since   1.0
	 */
	protected function populateState($ordering = 'a.title', $direction = 'asc')
	{
		// Initialise variables.
		$app = JFactory::getApplication();

		$value = $app->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $value);

		$value = $app->getUserStateFromRequest($this->context.'.filter.course_id', 'filter_course_id');
		$this->setState('filter.course_id', $value);
		
		$value = $app->getUserStateFromRequest($this->context.'.filter.schedule_id', 'filter_schedule_id');
		$this->setState('filter.schedule_id', $value);

		// Set list state ordering defaults.
		parent::populateState($ordering, $direction);
	}

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return  JDatabaseQuery
	 * @since   1.0
	 */
	protected function getListQuery()
	{
		// Initialise variables.
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
		$user	= JFactory::getUser();
		$uid	= $user->get('id');
		
		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select',
				'a.id, a.title, a.alias, a.checked_out, a.checked_out_time, a.course_id,' .
				'a.min_applicants, a.max_applicants, a.start_date, a.end_date, a.apply_up, a.apply_down, ' .
				'(SELECT MAX(r.id) FROM #__regonline_registrations AS r WHERE r.registered_by='.$uid.' AND r.schedule_id=a.id) AS is_applied, ' .
				'(SELECT count(r2.id) FROM #__regonline_registrations AS r2 WHERE r2.schedule_id=a.id) AS applicants, ' .
				'a.published, a.access, a.created, a.ordering, a.language'
			)
		);
		$query->from('#__regonline_schedules AS a');

		// Join over the language
		$query->select('l.title AS language_title');
		$query->join('LEFT', '`#__languages` AS l ON l.lang_code = a.language');

		// Join over the users for the checked out user.
		$query->select('uc.name AS editor');
		$query->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');

		// Join over the asset groups.
		$query->select('ag.title AS access_level');
		$query->join('LEFT', '#__viewlevels AS ag ON ag.id = a.access');

		// Join over the courses.
		$query->select('c.title AS course_title');
		$query->join('LEFT', '#__regonline_courses AS c ON c.id = a.course_id');

		// Join over the users for the author.
		$query->select('ua.name AS author_name');
		$query->join('LEFT', '#__users AS ua ON ua.id = a.created_by');

		// Filter by search in title
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			if (stripos($search, 'id:') === 0) {
				$query->where('a.id = '.(int) substr($search, 3));
			} else {
				$search = $db->Quote('%'.$db->getEscaped($search, true).'%');
				$query->where('(a.title LIKE '.$search
					.' OR a.alias LIKE '.$search
					.' OR course_title LIKE '.$search
					.')');
			}
		}

		// Filter by access level.
		$accesslevels = implode(',', $user->getAuthorisedViewLevels());
		$query->where('a.access in ('.$accesslevels.')');

		$query->where('a.published = 1');

		// Filter by a single or group of categories.
		$courseId = $this->getState('filter.course_id');
		if (is_numeric($courseId)) {
			$query->where('a.course_id = '.(int) $courseId);
		}

		// Add the list ordering clause.
		$orderCol	= $this->state->get('list.ordering');
		$orderDirn	= $this->state->get('list.direction');
		if ($orderCol == 'a.ordering' || $orderCol == 'course_title') {
			$orderCol = 'course_title '.$orderDirn.', a.ordering';
		}
		
		if (!empty($orderCol) && !empty($orderDirn) )
			$query->order($db->getEscaped($orderCol.' '.$orderDirn));

		return $query;
	}
}
