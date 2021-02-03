<div class="sourcesRsses form">
<?php echo $this->Form->create('SourcesRss'); ?>
	<fieldset>
		<legend><?php echo __('Cpadmin Edit Sources Rss'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('link');
		echo $this->Form->input('source_id');
		echo $this->Form->input('category_id');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('SourcesRss.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('SourcesRss.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Sources Rsses'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Sources'), array('controller' => 'sources', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Source'), array('controller' => 'sources', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
