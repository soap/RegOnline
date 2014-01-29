<?php
defined('_JEXEC') or die();

/**
 * 
 * Twitter Bootstrap menu class for Joomla! 2.5
 * @internal This class did not load any Twitter Bootstrap style sheet
 * @author Prasit Gebsaap
 * @version 1.0
 */
class JMenuContext
{
    protected $component;

    protected $items;

	/**
	 * 
	 * Constructor 
	 * @param string $component component lowercase name with com_
	 */
    public function __construct($component = null)
    {
        $this->items = array();

        $this->component = (empty($component) ? JRequest::getVar('option') : $component);
    }


    protected function addItem($html)
    {
        $this->items[] = $html;
    }

	/**
	 * 
	 * Render menu after menu items were added
	 * @param array $disabled_options
	 */
    public function render($disabled_options = array())
    {
        $class = '';

        if (isset($disabled_options['class']) && $disabled_options['class'] != '') {
            $class = ' ' . $disabled_options['class'];
        }

        if (count($this->items) <= 2) {
            $this->items = array();

            $html = array();
            $html[] = '<div class="btn-group">';
            $html[] = '    <a class="btn btn-link disabled' . $class . '" href="javascript: void(0);"><span class="caret"></span></a>';
            $html[] = '</div>';

            return implode("\n", $html);
        }
        else {
            $html = implode("\n", $this->items);

            $this->items = array();

            return $html;
        }
    }
	
    /**
     * 
     * Start menu item ...
     * @param array $options
     * @param bool $return if true then returns HTML only
     */

    public function start($options = array(), $return = false)
    {
        $class  = '';
        $title  = '';
        $pull   = '';
        $single = false;

        if (isset($options['class']) && $options['class'] != '') {
            $class = ' ' . $options['class'];
        }

        if (isset($options['title']) && $options['title'] != '') {
            $title = $options['title'] . ' ';
        }

        if (isset($options['single-button']) && $options['single-button'] != '') {
            $single = (bool) $options['single-button'];
        }

        if (isset($options['pull']) && $options['pull'] != '') {
            $pull = ' pull-' . $options['pull'];
        }

        $html = array();

        if (!$single) {
            $html[] = '<div class="btn-group' . $pull . '">';
            $html[] = '    <a class="btn dropdown-toggle' . $class.'" data-toggle="dropdown" href="#">' . $title . '<span class="caret"></span></a>';
            $html[] = '    <ul class="dropdown-menu">';
        }
        else {
            $html[] = '<div class="btn ' . $class.'">' . $title . '</div>';
        }

        if ($return) return implode("\n", $html);

        $this->addItem(implode("\n", $html));
    }

	/**
	 * 
	 * Create menu item using Link (GET method)
	 * @param unknown_type $icon
	 * @param unknown_type $title
	 * @param unknown_type $action
	 * @param unknown_type $return
	 */
    public function itemLink($icon, $title, $action, $return = false)
    {
        $html = array();

        $html[] = '        <li>';
        $html[] = '            <a href="' . $action . '"><span aria-hidden="true" class="' . $icon . '"></span> ' . JText::_($title) . '</a>';
        $html[] = '        </li>';

        if ($return) return implode("\n", $html);

        $this->addItem(implode("\n", $html));
    }
    
    /**
     * 
     * Create collapse menu items
     * @param unknown_type $icon Twitter Bootstrap icon class
     * @param unknown_type $title
     * @param unknown_type $action
     * @param unknown_type $return
     */
    public function itemCollapse($icon, $title, $action, $return = false)
    {
        $html = array();

        $html[] = '        <li>';
        $html[] = '            <a href="' . $action . '" data-toggle="collapse"><span aria-hidden="true" class="' . $icon . '"></span> ' . JText::_($title) . '</a>';
        $html[] = '        </li>';

        if ($return) return implode("\n", $html);

        $this->addItem(implode("\n", $html));
    }

	/**
	 * 
	 * Create place holder menu item
	 * @param unknown_type $icon Twitter Bootstrap icon class
	 * @param unknown_type $title
	 * @param unknown_type $return
	 */
    public function itemPlaceholder($icon, $title, $return = false)
    {
        $html = array();

        $html[] = '        <li>';
        $html[] = '            <span aria-hidden="true" class="' . $icon . '"></span> ' . JText::_($title);
        $html[] = '        </li>';

        if ($return) return implode("\n", $html);

        $this->addItem(implode("\n", $html));
    }

	/**
	 * 
	 * Create menu item which open popup dialog 
	 * @param unknown_type $icon	Twitter Bootstrap icon class
	 * @param unknown_type $title
	 * @param unknown_type $action
	 * @param unknown_type $click
	 * @param unknown_type $size_x
	 * @param unknown_type $size_y
	 * @param unknown_type $return
	 */
    public function itemModal($icon, $title, $action, $click = null, $size_x = '800', $size_y = '500', $return = false)
    {
        static $modal;

        $onclick = (empty($click) ? '' : ' onclick="' . $click . '"');

        // Load the modal behavior script.
        if (!isset($modal)) JHtml::_('behavior.modal', 'a.modal_item');
        $html = array();

        $html[] = '        <li>';
        $html[] = '            <a class="modal_item" href="' . $action . '" rel="{handler: \'iframe\', size: {x: ' . $size_x . ', y: ' . $size_y.'}}" ' . $onclick . '>';
        $html[] = '                <span aria-hidden="true" class="' . $icon.'"></span> ' . JText::_($title);
        $html[] = '            </a>';
        $html[] = '        </li>';

        if ($return) return implode("\n", $html);

        $this->addItem(implode("\n", $html));
    }

	/**
	 * 
	 * Create menu item using JavaScript 
	 * @param unknown_type $icon
	 * @param unknown_type $title
	 * @param unknown_type $action
	 * @param unknown_type $return
	 */
    public function itemJavaScript($icon, $title, $action, $return = false)
    {
        $html = array();

        $html[] = '        <li>';
        $html[] = '            <a onclick="' . $action . '" href="javascript:void(0);"><span aria-hidden="true" class="' . $icon . '"></span> ' . JText::_($title) . '</a>';
        $html[] = '        </li>';

        if ($return) return implode("\n", $html);

        $this->addItem(implode("\n", $html));
    }

	/**
	 * 
	 * Create menu item separator
	 * @param unknown_type $return
	 */
    public function itemDivider($return = false)
    {
        if ($return) return '        <li class="divider"></li>';
        $this->addItem('        <li class="divider"></li>');
    }

	/**
	 * 
	 * Create edit menu item
	 * @param unknown_type $asset	Sub-controller name (prefix)
	 * @param unknown_type $id
	 * @param unknown_type $access
	 */
    public function itemEdit($asset, $id = 0, $access = false)
    {
        if (!$access) return '';

        $icon   = 'icon-pencil';
        $action = JRoute::_('index.php?option=' . $this->component . '&task=' . strval($asset) . '.edit&id=' . intval($id));
        $title  = JText::_('JACTION_EDIT');

        return $this->itemLink($icon, $title, $action);
    }

	/**
	 * 
	 * Create trash menu item
	 * @param unknown_type $asset Sub-controller name (prefix)
	 * @param unknown_type $id
	 * @param unknown_type $access
	 */
    public function itemTrash($asset, $id, $access = false)
    {
        if (!$access) return '';

        $icon   = 'icon-trash';
        $action = "return listItemTask('cb" . $id . "','" . $asset . ".trash');";
        $title  = JText::_('JACTION_TRASH');

        return $this->itemJavaScript($icon, $title, $action);
    }
	
	/**
	 * 
	 * Create delete menu item
	 * @param unknown_type $asset	Sub-controller name (prefix)
	 * @param unknown_type $id
	 * @param unknown_type $access
	 */
    public function itemDelete($asset, $id, $access = false)
    {
        if (!$access) return '';

        $icon   = 'icon-remove';
        $action = "return listItemTask('cb" . $id . "','" . $asset . ".delete');";
        $title  = JText::_('JACTION_DELETE');

        return $this->itemJavaScript($icon, $title, $action);
    }

    /**
     * 
     * Create multiple menu items
     * @param unknown_type $actions
     */
    public function bulkItems($actions)
    {
        $message = addslashes(JText::_('JLIB_HTML_PLEASE_MAKE_A_SELECTION_FROM_THE_LIST'));
        $html    = array();

        if (count($actions) == 0) {
            $html[] = '<div class="btn-group" id="bulk-action-menu">';
            $html[] = '    <a class="btn btn-primary disabled" href="javascript: void(0);"><span class="caret"></span></a>';
            $html[] = '</div>';

            return implode("\n", $html);
        }

        $html[] = '<div class="btn-group" id="bulk-action-menu">';
        $html[] = '    <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>';
        $html[] = '    <ul class="dropdown-menu">';

        foreach($actions AS $action)
        {
            $js = "if (document.adminForm.boxchecked.value==0){alert('" . $message . "');}"
                . "else{Joomla.submitbutton('" . $action->value . "')}";

            $icon = 'icon-chevron-right';

            if (strpos($action->value, '.publish') !== false)   $icon = 'icon-eye-open';
            if (strpos($action->value, '.unpublish') !== false) $icon = 'icon-eye-close';
            if (strpos($action->value, '.archive') !== false)   $icon = 'icon-folder-open';
            if (strpos($action->value, '.trash') !== false)     $icon = 'icon-trash';
            if (strpos($action->value, '.delete') !== false)    $icon = 'icon-remove';
            if (strpos($action->value, '.checkin') !== false)   $icon = 'icon-ok-sign';

            $html[] = $this->itemJavaScript($icon, $action->text, $js, true);
        }

        $html[] = '    </ul>';
        $html[] = '</div>';

        return implode("\n", $html);
    }

	/**
	 * 
	 * End of menu HTML
	 * @param unknown_type $return if true, return HTML tags only
	 */
    public function end($return = false)
    {
        $html = array();

        $html[] = '    </ul>';
        $html[] = '</div>';

        if ($return) return implode("\n", $html);

        $this->addItem(implode("\n", $html));
    }
}
