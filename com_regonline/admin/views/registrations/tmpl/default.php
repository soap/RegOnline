<?php
defined ('_JEXEC') or die;

JHtml::_('behavior.tooltip');

$user		= JFactory::getUser();
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
?>
<form action="<?php echo JRoute::_('index.php?option=com_regonline&view=registrations');?>" method="post" name="adminForm">
	<fieldset id="filter-bar">
		<div class="filter-search fltlft">
			<label class="filter-search-lbl" for="filter_search">
				<?php echo JText::_('JSEARCH_FILTER_LABEL'); ?>:</label>
			<input type="text" name="filter_search" id="filter_search"
				value="<?php echo $this->escape($this->state->get('filter.search')); ?>"
				title="<?php echo JText::_('COM_REGONLINE_REGISTRATIONS_FILTER_SEARCH_DESC'); ?>" />

			<button type="submit" class="btn">
				<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
			<button type="button" onclick="document.id('filter_search').value='';this.form.submit();">
				<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>

		</div>
		<div class="filter-select fltrt">
			<select name="filter_schedule_id" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('COM_REGONLINE_OPTION_SELECT_SCHEDULE');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('regonline.scheduleOptions'),
					'value', 'text', $this->state->get('filter.schedule_id'));?>
			</select>
					
			<select name="filter_published" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions', array('trash'=>0, 'archived'=>0)),
					'value', 'text', $this->state->get('filter.published'), true);?>
			</select>

			<select name="filter_access" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_ACCESS');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('access.assetgroups'),
					'value', 'text', $this->state->get('filter.access'));?>
			</select>

			<select name="filter_language" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_LANGUAGE');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('contentlanguage.existing', true, true),
					'value', 'text', $this->state->get('filter.language'));?>
			</select>
		</div>
	</fieldset>
	<div class="clr"> </div>


	<table class="adminlist">
		<thead>
			<tr>
				<th width="1%">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(this)" />
				</th>
				<th>
					<?php echo JHtml::_('grid.sort', 'JGLOBAL_TITLE', 'schedule_title', $listDirn, $listOrder); ?>
				</th>
				<th width="10%">
					<?php echo JHtml::_('grid.sort', 'COM_REGONLINE_HEADING_REGISTERED_BY', 'a.registered_by', $listDirn, $listOrder); ?>
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'COM_REGONLINE_HEADING_REGISTER_DATE', 'a.registered', $listDirn, $listOrder); ?>
				</th>				
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'JPUBLISHED', 'a.state', $listDirn, $listOrder); ?>
				</th>

				<th width="10%" class="nowrap">
					<?php echo JHtml::_('grid.sort',  'JGRID_HEADING_ORDERING', 'a.ordering', $listDirn, $listOrder); ?>
					<?php echo JHtml::_('grid.order',  $this->items, 'filesave.png', 'registrations.saveorder'); ?>
				</th>
				<th width="10%">
					<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ACCESS', 'access_level', $listDirn, $listOrder); ?>
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_LANGUAGE', 'language', $listDirn, $listOrder); ?>
				</th>
				<th width="1%" class="nowrap">
					<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="15">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php foreach ($this->items as $i => $item) :
			$item->max_ordering = 0; //??
			$ordering	= ($listOrder == 'a.ordering');
			$canCreate	= $user->authorise('core.create',		'com_regonline');
			$canEdit	= $user->authorise('core.edit',			'com_regonline.registration.'.$item->id);
			$canCheckin	= $user->authorise('core.manage',		'com_checkin') || $item->checked_out == $user->get('id') || $item->checked_out == 0;
			$canChange	= $user->authorise('core.edit.state',	'com_regonline.registration.'.$item->id) && $canCheckin;
			?>
			<tr class="row<?php echo $i % 2; ?>">
				<td class="center">
					<?php echo JHtml::_('grid.id', $i, $item->id); ?>
				</td>			
				<td>
					<?php if ($item->checked_out) : ?>
						<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'registrations.', $canCheckin); ?>
					<?php endif; ?>
					<?php if ($canCreate || $canEdit) : ?>
					<a href="<?php echo JRoute::_('index.php?option=com_regonline&task=registration.edit&id='.$item->id);?>">
						<?php echo $this->escape($item->schedule_title); ?></a>
					<?php else : ?>
						<?php echo $this->escape($item->schedule_title); ?>
					<?php endif; ?>
					<p class="smallsub">
						<?php if (empty($item->note)) : ?>
							<?php echo JText::sprintf('JGLOBAL_LIST_ALIAS', $this->escape($item->alias));?>
						<?php else : ?>
							<?php echo JText::sprintf('JGLOBAL_LIST_ALIAS_NOTE', $this->escape($item->alias), $this->escape($item->note));?>
						<?php endif; ?></p>
				</td>
				<td class="center">
					<?php echo $this->escape($item->register_name); ?>
				</td>
				<td class="center">
					<?php echo JHTML::_('date',$item->registered, 'Y-m-d'); ?>
				</td>					
				<td class="center">
					<?php echo JHtml::_('jgrid.published', $item->published, $i, 'registrations.', $canChange); ?>
				</td>
				<td class="order">
					<?php if ($canChange) : ?>
						<span><?php echo $this->pagination->orderUpIcon($i,
							($item->schedule_id == @$this->items[$i-1]->schedule_id),
							'registrations.orderup', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
						<span><?php echo $this->pagination->orderDownIcon($i,
							$this->pagination->total,
							($item->schedule_id == @$this->items[$i+1]->schedule_id),
							'registrations.orderdown', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
						<?php $disabled = $ordering ?  '' : 'disabled="disabled"'; ?>
						<input type="text" name="order[]" size="5" value="<?php echo $item->ordering;?>" <?php echo $disabled ?> class="text-area-order" />
					<?php else : ?>
						<?php echo (int) $item->ordering; ?>
					<?php endif; ?>
				</td>
				<td class="center">
					<?php echo $this->escape($item->access_level); ?>
				</td>
				<td class="center">
					<?php if ($item->language == '*'): ?>
						<?php echo JText::_('JALL'); ?>
					<?php else: ?>
						<?php echo $item->language_title ? $this->escape($item->language_title) : JText::_('JUNDEFINED'); ?>
					<?php endif; ?>
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
