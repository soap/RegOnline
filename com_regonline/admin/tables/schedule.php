<?php
defined('_JEXEC') or die;
jimport('joomla.database.table');

/**
 * Schedule table.
 *
 * @package     RegOnline
 * @subpackage  Admin
 * @since       1.0
 */
class RegonlineTableSchedule extends JTable
{
	/**
	 * Constructor.
	 *
	 * @param   JDatabase  $db  A database connector object.
	 *
	 * @return  RegonlineTableCourse
	 * @since   1.0
	 */
	public function __construct($db)
	{
		parent::__construct('#__regonline_schedules', 'id', $db);
	}

	/**
	 * Overloaded bind function to pre-process the params.
	 *
	 * @param   array   $array   The input array to bind.
	 * @param   string  $ignore  A list of fields to ignore in the binding.
	 *
	 * @return  null|string	null is operation was satisfactory, otherwise returns an error
	 * @see     JTable:bind
	 * @since   1.0
	 */
	public function bind($array, $ignore = '')
	{
		if (isset($array['params']) && is_array($array['params'])) {
			$registry = new JRegistry();
			$registry->loadArray($array['params']);
			$array['params'] = (string) $registry;
		}

		return parent::bind($array, $ignore);
	}

	/**
	 * Overloaded check method to ensure data integrity.
	 *
	 * @return  boolean  True on success.
	 * @since   1.0
	 */
	public function check()
	{
		// Check for valid name.
		if (trim($this->title) === '') {
			$this->setError(JText::_('COM_REGONLINE_ERROR_SCHEDULE_TITLE'));
			return false;
		}

		if ($this->start_date >= $this->end_date) {
			$this->setError(JText::_('COM_REGONLINE_ERROR_SCHEDULE_DATE'));
			return false;
		}
		
		if ($this->apply_up >= $this->apply_down) {
			$this->setError(JText::_('COM_REGONLINE_ERROR_SCHEDULE_APPLICATION_DATE'));
			return false;
		}
		
		if (empty($this->min_applicants) || ($this->min_applicants < 0))
			$this->min_applicants = 0;
			
		if (empty($this->max_applicants) || ($this->max_applicants < 0))
			$this->max_applicants = 0;			
			
		return true;
	}

	/**
	 * Overload the store method for the Weblinks table.
	 *
	 * @param   boolean  $updateNulls  Toggle whether null values should be updated.
	 *
	 * @return  boolean  True on success, false on failure.
	 * @since   1.0
	 */
	public function store($updateNulls = false)
	{
		// Initialiase variables.
		$date	= JFactory::getDate()->toSQL();
		$userId	= JFactory::getUser()->get('id');

		if (empty($this->id)) {
			// New record.
			$this->created		= $date;
			$this->created_by	= $userId;
		} 
		else {
			// Existing record.
			$this->modified	= $date;
			$this->modified_by	= $userId;
		}

		// Attempt to store the data.
		return parent::store($updateNulls);
	}
}