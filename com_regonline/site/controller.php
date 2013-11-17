<?php
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

/**
 * Regonline Component Controller
 *
 * @package     RegOnline
 * @subpackage  
 * @since       1.0
 */
class RegonlineController extends JController
{
    public function display($cachable = false, $urlparams = false)
    {
		JLoader::register('RegonlineHelper', JPATH_COMPONENT.'/helpers/regonline.php');
		
        // Override method arguments
        $urlparams = array('id' => 'INT');

        // Display the view
        parent::display($cachable, $urlparams);

        // Return own instance for chaining
        return $this;
    }	
}