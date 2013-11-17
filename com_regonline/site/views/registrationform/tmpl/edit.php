<?php
defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.calendar');
JHtml::_('behavior.formvalidation');

// Create shortcut to parameters.
$params = $this->state->get('params');
$user   = JFactory::getUser();
?>
<script type="text/javascript">

Joomla.submitbutton = function(task)
{
	if (task == 'registrationform.cancel' || document.formvalidator.isValid(document.id('item-form'))) {
        Joomla.submitform(task, document.getElementById('item-form'));
	} else {
		alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
	}
}
</script>
<div class="edit item-page<?php echo $this->pageclass_sfx; ?>">
<?php if ($params->get('show_page_heading', 0)) : ?>
<h1>
	<?php echo $this->escape($params->get('page_heading')); ?>
</h1>
<?php endif; ?>

<form action="<?php echo htmlspecialchars(JFactory::getURI()->toString()); ?>" method="post" name="adminForm" id="item-form" class="form-validate form-inline">
	<fieldset>
		<div class="formelm-buttons btn-toolbar">
            <?php echo $this->toolbar; ?>
		</div>
		
		<div class="formelm control-group">
			<div class="control-label">
		    	<?php echo $this->form->getLabel('alias'); ?>
		    </div>
		    <div class="controls">
		    	<?php echo $this->form->getInput('alias'); ?>
		    </div>
		</div>
		<div class="formelm control-group">
			<div class="control-label">
		    	<?php echo $this->form->getLabel('schedule_id'); ?>
		    </div>
		    <div class="controls">
		    	<?php echo $this->form->getInput('schedule_id'); ?>
		    </div>
		</div>
		<div class="formelm control-group">
			<div class="control-label">
		    	<?php echo $this->form->getLabel('registered_by'); ?>
		    </div>
		    <div class="controls">
		    	<?php echo $this->form->getInput('registered_by'); ?>
		    </div>
		</div>		
		<div class="formelm control-group">
			<div class="control-label">
		    	<?php echo $this->form->getLabel('note'); ?>
		    </div>
		    <div class="controls">
		    	<?php echo $this->form->getInput('note'); ?>
		    </div>
		</div>

	</fieldset>
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="return" value="<?php echo $this->return_page;?>" />
    <input type="hidden" name="view" value="<?php echo htmlspecialchars($this->get('Name'), ENT_COMPAT, 'UTF-8');?>" />
	<?php echo JHtml::_( 'form.token' ); ?>
</form>
</div>