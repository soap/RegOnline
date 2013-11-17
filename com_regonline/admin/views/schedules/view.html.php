<?php
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * Regonline view.
 *
 * @package     RegOnline
 * @subpackage  Admin
 * @since       1.0
 */
class RegonlineViewSchedules extends JViewLegacy
{
	/**
	 * @var    array  The array of records to display in the list.
	 * @since  1.0
	 */
	protected $items;

	/**
	 * @var    JPagination  The pagination object for the list.
	 * @since  1.0
	 */
	protected $pagination;

	/**
	 * @var    JObject	The model state.
	 * @since  1.0
	 */
	protected $state;

	/**
	 * Prepare and display the Schedules view.
	 *
	 * @return  void
	 * @since   1.0
	 */
	public function display($tp = NULL)
	{
		// Initialise variables.
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		// Add the toolbar if it is not in modal
		if ($this->getLayout() !== 'modal') $this->addToolbar();
		
		// Display the view layout.
		parent::display();
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 * @since   1.0
	 */
	protected function addToolbar()
	{
		// Initialise variables.
		$state	= $this->get('State');
		$canDo	= RegonlineHelper::getActions();

		JToolBarHelper::title(JText::_('COM_REGONLINE_SCHEDULES_TITLE'));

		if ($canDo->get('core.create')) {
			JToolBarHelper::addNew('schedule.add', 'JTOOLBAR_NEW');
		}

		if ($canDo->get('core.edit')) {
			JToolBarHelper::editList('schedule.edit', 'JTOOLBAR_EDIT');
		}

		if ($canDo->get('core.edit.state')) {
			JToolBarHelper::publishList('schedules.publish', 'JTOOLBAR_PUBLISH');
			JToolBarHelper::unpublishList('schedules.unpublish', 'JTOOLBAR_UNPUBLISH');
			JToolBarHelper::archiveList('schedules.archive','JTOOLBAR_ARCHIVE');
		}

		if ($state->get('filter.published') == -2 && $canDo->get('core.delete')) {
			JToolBarHelper::deleteList('', 'schedules.delete','JTOOLBAR_EMPTY_TRASH');
		} 
		else if ($canDo->get('core.edit.state')) {
			JToolBarHelper::trash('schedules.trash','JTOOLBAR_TRASH');
		}

	}
}