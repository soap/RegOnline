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
class RegonlineViewSchedule extends JViewLegacy
{
	/**
	 * @var    JObject	The data for the record being displayed.
	 * @since  1.0
	 */
	protected $item;

	/**
	 * @var    JForm  The form object for this record.
	 * @since  1.0
	 */
	protected $form;

	/**
	 * @var    JObject  The model state.
	 * @since  1.0
	 */
	protected $state;

	/**
	 * Prepare and display the Schedule view.
	 *
	 * @return  void
	 * @since   1.0
	 */
	public function display()
	{
		// Intialiase variables.
		$this->item		= $this->get('Item');
		$this->form		= $this->get('Form');
		$this->state	= $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$this->addToolbar();
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
		JRequest::setVar('hidemainmenu', true);

		$user		= JFactory::getUser();
		$isNew		= ($this->item->id == 0);
		$checkedOut	= !($this->item->checked_out == 0 || $this->item->checked_out == $user->get('id'));
		$canDo		= RegonlineHelper::getActions();

		JToolBarHelper::title(
			JText::_(
				'COM_REGONLINE_'.
				($checkedOut
					? 'VIEW_SCHEDULE'
					: ($isNew ? 'ADD_SCHEDULE' : 'EDIT_SCHEDULE')).'_TITLE'
			)
		);

		// If not checked out, can save the item.
		if (!$checkedOut && $canDo->get('core.edit')) {
			JToolBarHelper::apply('schedule.apply', 'JTOOLBAR_APPLY');
			JToolBarHelper::save('schedule.save', 'JTOOLBAR_SAVE');
			JToolBarHelper::custom('schedule.save2new', 'save-new.png', null, 'JTOOLBAR_SAVE_AND_NEW', false);
		}

		// If an existing item, can save to a copy.
		if (!$isNew && $canDo->get('core.create')) {
			JToolBarHelper::custom('schedule.save2copy', 'save-copy.png', null, 'JTOOLBAR_SAVE_AS_COPY', false);
		}

		if (empty($this->item->id))  {
			JToolBarHelper::cancel('schedule.cancel', 'JTOOLBAR_CANCEL');
		}
		else {
			JToolBarHelper::cancel('schedule.cancel', 'JTOOLBAR_CLOSE');
		}
	}
}