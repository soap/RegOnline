<?php
defined('_JEXEC') or die;

class com_RegOnlineInstallerScript 
{
	function install($parent) {
		echo '<p>' . JText::sprintf('COM_ASTERMAN_INSTALL_TEXT', $parent->get('manifest')->version) . '</p>';
	}
	
	function uninstall($parent) {
		echo '<p>' . JText::sprintf('COM_ASTERMAN_UNINSTALL_TEXT', $parent->get('manifest')->version) . '</p>';
	}
	
	function update($parent) {
		echo '<br /><br /><p>' . JText::sprintf('COM_ASTERMAN_UPDATE_TEXT', $parent->get('manifest')->version) . '</p>';	
	}

}