<?php
defined('_JEXEC') or die;

// Base this model on the backend version.
JLoader::register('RegonlineModelRegistration', JPATH_ADMINISTRATOR . '/components/com_regonline/models/registration.php');

/**
 * The Regonline Registrationform model extends from backend Registration model.
 *
 * @package     Registration Online
 * @subpackage  com_regonline
 * @since       1.0
 */
class RegonlineModelRegistrationform extends RegonlineModelRegistration
{
	
	/**
	 * 
	 * Construnctor
	 * @param unknown_type $config
	 */
	public function __construct($config = array())
	{
		parent::__construct($config);
		
		JForm::addFormPath(JPATH_ADMINISTRATOR . '/components/com_regonline/models/forms');
		JForm::addFieldPath(JPATH_ADMINISTRATOR . '/components/com_regonline/models/fields');
	}

	/**
	 * Method to get a Registrationform.
	 *
	 * @param   integer  $pk  An optional id of the object to get, otherwise the id from the model state is used.
	 *
	 * @return  mixed    Category data object on success, false on failure.
	 * @since   1.6
	 */
	public function getItem($pk = null)
	{
		if ($result = parent::getItem($pk)) {
			if (empty($result->id) || empty($result->registered_by)) {
				$result->registered_by = JFactory::getUser()->get('id');
			}
		}

		return $result;
	}
	
	public function preprocessForm(JForm $form, $data, $group = 'content')
	{
		parent::preprocessForm($form, $data, $group);
		
		$form->setFieldAttribute('registered_by', 'type', 'hidden');
		$form->setFieldAttribute('registered_by', 'filter', 'unset');
	}
	
    public function getReturnPage()
    {
        return base64_encode($this->getState('return_page'));
    }

    /**
     * Method to auto-populate the model state.
     * Note. Calling getState in this method will result in recursion.
     *
     * @return    void
     */
    protected function populateState()
    {
        // Load state from the request.
        $pk = JRequest::getInt('id');
        $this->setState($this->getName() . '.id', $pk);

        $return = JRequest::getVar('return', null, 'default', 'base64');
        $this->setState('return_page', base64_decode($return));

        // Load the parameters.
        $params = JFactory::getApplication()->getParams();
        $this->setState('params', $params);

        $this->setState('layout', JFactory::getApplication()->input->get('layout', '', 'string'));
    }
}