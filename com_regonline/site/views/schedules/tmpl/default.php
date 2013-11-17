<?php
defined('_JEXEC') or die;
JHtml::_('behavior.tooltip');

$user		= JFactory::getUser();
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
?>
<form action="<?php echo JRoute::_('index.php?option=com_regonline&view=schedules');?>" method="post" name="adminForm">
	<div class="btn-toolbar toolbar-top">
		<?php echo $this->toolbar; ?>
	</div>
	<table class="adminlist table table-striped table-hover">
		<thead>
			<tr>
				<th>
					<?php echo JHtml::_('grid.sort', 'JGLOBAL_TITLE', 'a.title', $listDirn, $listOrder); ?>
				</th>
				<th width="30%">
					<?php echo JHtml::_('grid.sort', 'COM_REGONLINE_HEADING_COURSE', 'course_title', $listDirn, $listOrder); ?>
				</th>
				<th width="10%">
					<?php echo JHtml::_('grid.sort', 'COM_REGONLINE_HEADING_TRAINING_PERIOD', 'a.start_date', $listDirn, $listOrder); ?>
				</th>
				<th width="10%">
					<?php echo JHtml::_('grid.sort', 'COM_REGONLINE_HEADING_APPLY_PERIOD', 'a.apply_up', $listDirn, $listOrder); ?>
				</th>
				<th width="10%">
					<?php echo JHtml::_('grid.sort', 'COM_REGONLINE_HEADING_MIN_APPLICANTS', 'a.min_applicants', $listDirn, $listOrder); ?>
				</th>
				<th width="10%">
					<?php echo JHtml::_('grid.sort', 'COM_REGONLINE_HEADING_MAX_APPLICANTS', 'a.max_applicants', $listDirn, $listOrder); ?>
				</th>		
				<th width="10%">
					<?php echo JHtml::_('grid.sort', 'COM_REGONLINE_HEADING_APPLICANTS', 'applicants', $listDirn, $listOrder); ?>
				</th>			
				<th width="1%" class="nowrap">
					<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="8">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php foreach ($this->items as $i => $item) :
			$item->max_ordering = 0; //??
			$ordering	= ($listOrder == 'a.ordering');
			$canCreate	= $user->authorise('core.create',		'com_regonline');
			$canEdit	= $user->authorise('core.edit',			'com_regonline.schedule.'.$item->id);
			$canEditReg = $user->authorise('core.edit.own',		'com_regonline') && $item->is_applied;
			$canCheckin	= $user->authorise('core.manage',		'com_checkin') || $item->checked_out == $user->get('id') || $item->checked_out == 0;
			$canChange	= $user->authorise('core.edit.state',	'com_regonline.schedule.'.$item->id) && $canCheckin;
			?>
			<tr class="row<?php echo $i % 2; ?>">
				<td>
					<div class="btn-group pull-left">
            		<?php 
            			$this->menu->start(array('class' => 'btn-mini'));
            			$action = 'index.php?option=com_regonline';
            			if ($item->is_applied > 0) { 
            				$action .= '&task=registrationforms.delete&cid[]='.$item->is_applied;
            				$action .= '&'.JSession::getFormToken() . '=1';
	                   		$this->menu->itemLink('icon-minus', 'Cancel Register', $action, false);  
            			}else{
            				$action .= '&task=registrationform.add&schedule_id='.$item->id;
	                   		$this->menu->itemLink('icon-plus', 'Register', $action, false);
            			}
            			$this->menu->itemEdit('registrationform', $item->is_applied, ($canEdit || $canEditReg));
	                  	$this->menu->end();
	
	                    echo $this->menu->render(array('class' => 'btn-mini'));
	                 ?>
            		</div>
            		<?php echo $this->escape($item->title); ?>
				</td>		
				<td class="center">
					<?php echo $this->escape($item->course_title); ?>
				</td>
				<td class="center">
					<?php echo JHtml::_('date',$item->start_date, 'Y-m-d'); ?> / <?php echo JHtml::_('date',$item->end_date, 'Y-m-d'); ?>
				</td>
				<td class="center">
					<?php echo JHtml::_('date',$item->apply_up, 'Y-m-d'); ?> / <?php echo JHtml::_('date',$item->apply_down, 'Y-m-d'); ?>
				</td>
				<td class="center">
					<?php echo $item->min_applicants; ?>	
				</td>
				<td class="center">
					<?php echo $item->max_applicants; ?>	
				</td>				
				<td class="center">
					<?php echo $item->applicants; ?>	
				</td>
				<td class="center">
					<?php echo (int) $item->id; ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
	<?php echo JHtml::_('form.token'); ?>
</form>
