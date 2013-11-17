<?php
defined('_JEXEC') or die();

// Include dependencies
jimport('joomla.application.component.controller');
//jimport('jongman.framework');

JLoader::register('BSToolbar', JPATH_COMPONENT.'/helpers/toolbar/toolbar.php');
JLoader::register('BSMenuContext', JPATH_COMPONENT.'/helpers/menu/context.php');

$controller = JControllerLegacy::getInstance('regonline');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();