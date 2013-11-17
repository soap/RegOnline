<?php
defined('_JEXEC') or die();

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_regonline')) {
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependencies
jimport('joomla.application.component.controller');

JLoader::register('JHtmlRegonline', JPATH_COMPONENT_ADMINISTRATOR.'/helpers/html/regonline.php');

$controller = JControllerLegacy::getInstance('regonline');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();