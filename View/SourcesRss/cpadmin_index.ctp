<div class="sourcesRsses index">
	<h2><?php echo __('Sources Rsses'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('link'); ?></th>
			<th><?php echo $this->Paginator->sort('source_id'); ?></th>
			<th><?php echo $this->Paginator->sort('category_id'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($sourcesRsses as $sourcesRss): ?>
	<tr>
		<td><?php echo h($sourcesRss['SourcesRss']['id']); ?>&nbsp;</td>
		<td><?php echo h($sourcesRss['SourcesRss']['link']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($sourcesRss['Source']['name'], array('controller' => 'sources', 'action' => 'view', $sourcesRss['Source']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($sourcesRss['Category']['name'], array('controller' => 'categories', 'action' => 'view', $sourcesRss['Category']['id'])); ?>
		</td>
		<td>
        <?php if($sourcesRss['SourcesRss']['status'] == 1) { ?>
         <span class="publish"> <?php echo $this->Html->image("publish.png", array("alt" => "publish", 'url' => array('action' => 'unpublish', $sourcesRss['SourcesRss']['id']))); ?></span>
        <?php }else { ?>
            <span class="unpublish"> <?php echo $this->Html->image("unpublish.png", array("alt" => "unpublish", 'url' => array('action' => 'publish', $sourcesRss['SourcesRss']['id']))); ?></span>
        <?php } ?> 
        </td>
		<td><?php echo h($sourcesRss['SourcesRss']['created']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $sourcesRss['SourcesRss']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $sourcesRss['SourcesRss']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $sourcesRss['SourcesRss']['id']), null, __('Are you sure you want to delete # %s?', $sourcesRss['SourcesRss']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Sources Rss'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Sources'), array('controller' => 'sources', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Source'), array('controller' => 'sources', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
	</ul>
</div>
