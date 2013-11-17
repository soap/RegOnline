<?php
defined('_JEXEC') or die;

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
?>
<script type="text/javascript">
window.addEvent('domready', function() {
	document.formvalidator.setHandler('zeroormoreint',
        function (value) {
       		regex=/^[0-9]{1,3}/;
            return regex.test(value);
		});
	});
	// Attach a behaviour to the submit button to check validation.
	Joomla.submitbutton = function(task)
	{
		var form = document.id('schedule-form');
		if (task == 'schedule.cancel' || document.formvalidator.isValid(form)) {
			<?php echo $this->form->getField('description')->save(); ?>
			Joomla.submitform(task, form);
		}
		else {
			<?php JText::script('COM_REGONLINE_ERROR_N_INVALID_FIELDS'); ?>
			// Count the fields that are invalid.
			var elements = form.getElements('fieldset').concat(Array.from(form.elements));
			var invalid = 0;

			for (var i = 0; i < elements.length; i++) {
				if (document.formvalidator.validate(elements[i]) == false) {
					valid = false;
					invalid++;
				}
			}

			alert(Joomla.JText._('COM_REGONLINE_ERROR_N_INVALID_FIELDS').replace('%d', invalid));
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_regonline&layout=edit&id='.(int) $this->item->id); ?>"
	method="post" name="adminForm" id="schedule-form" class="form-validate">
	<div class="width-60 fltlft">
		<fieldset class="adminform">
			<ul class="adminformlist">
				<li>
					<?php echo $this->form->getLabel('title'); ?>
					<?php echo $this->form->getInput('title'); ?>
				</li>

				<li>
					<?php echo $this->form->getLabel('alias'); ?>
					<?php echo $this->form->getInput('alias'); ?>
				</li>

				<li>
					<?php echo $this->form->getLabel('course_id'); ?>
					<?php echo $this->form->getInput('course_id'); ?>
				</li>

				<li>
					<?php echo $this->form->getLabel('published'); ?>
					<?php echo $this->form->getInput('published'); ?>
				</li>

				<li>
					<?php echo $this->form->getLabel('ordering'); ?>
					<?php echo $this->form->getInput('ordering'); ?>
				</li>

				<li>
					<?php echo $this->form->getLabel('access'); ?>
					<?php echo $this->form->getInput('access'); ?>
				</li>

				<li>
					<?php echo $this->form->getLabel('language'); ?>
					<?php echo $this->form->getInput('language'); ?>
				</li>

				<li>
					<?php echo $this->form->getLabel('note'); ?>
					<?php echo $this->form->getInput('note'); ?>
				</li>
			</ul>

			<?php echo $this->form->getLabel('description'); ?>
			<div class="clr"></div>
			<?php echo $this->form->getInput('description'); ?>

		</fieldset>
	</div>
	<div class="width-40 fltrt">
		<?php echo JHtml::_('sliders.start','schedule-sliders-'.$this->item->id, array('useCookie' => 1)); ?>

		<?php echo JHtml::_('sliders.panel', JText::_('COM_REGONLINE_GROUP_LABEL_PUBLISHING_DETAILS'), 'publishing-details'); ?>
			<fieldset class="panelform">
				<ul class="adminformlist">
					<?php foreach($this->form->getFieldset('publish') as $field): ?>
						<li><?php echo $field->label; ?>
							<?php echo $field->input; ?></li>
					<?php endforeach; ?>
				</ul>
			</fieldset>

			<?php echo JHtml::_('sliders.panel', JText::_('JGLOBAL_FIELDSET_METADATA_OPTIONS'), 'metadata'); ?>
			<fieldset class="panelform">
				<ul class="adminformlist">
					<?php foreach($this->form->getFieldset('metadata') as $field): ?>
						<li><?php echo $field->label; ?>
							<?php echo $field->input; ?></li>
					<?php endforeach; ?>
				</ul>
			</fieldset>
		<?php echo JHtml::_('sliders.end'); ?>

	</div>
	<div class="clr"></div>

	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>