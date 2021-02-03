<div class="sourcesRsses view">
<h2><?php echo __('Sources Rss'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($sourcesRss['SourcesRss']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Link'); ?></dt>
		<dd>
			<?php echo h($sourcesRss['SourcesRss']['link']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Source'); ?></dt>
		<dd>
			<?php echo $this->Html->link($sourcesRss['Source']['name'], array('controller' => 'sources', 'action' => 'view', $sourcesRss['Source']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Category'); ?></dt>
		<dd>
			<?php echo $this->Html->link($sourcesRss['Category']['name'], array('controller' => 'categories', 'action' => 'view', $sourcesRss['Category']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($sourcesRss['SourcesRss']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($sourcesRss['SourcesRss']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Sources Rss'), array('action' => 'edit', $sourcesRss['SourcesRss']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Sources Rss'), array('action' => 'delete', $sourcesRss['SourcesRss']['id']), null, __('Are you sure you want to delete # %s?', $sourcesRss['SourcesRss']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Sources Rsses'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sources Rss'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sources'), array('controller' => 'sources', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Source'), array('controller' => 'sources', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
