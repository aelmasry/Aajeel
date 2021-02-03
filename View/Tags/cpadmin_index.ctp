<div class="tags index">
	<h2><?php echo __('Tags'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('alias'); ?></th>
			<th><?php echo $this->Paginator->sort('hits'); ?></th>
			<th><?php echo $this->Paginator->sort('Publish'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th class="actions"></th>
	</tr>
	<?php foreach ($tags as $tag): ?>
	<tr>
		<td><?php echo h($tag['Tag']['id']); ?>&nbsp;</td>
		<td><?php echo h($tag['Tag']['name']); ?>&nbsp;</td>
		<td><?php echo h($tag['Tag']['alias']); ?>&nbsp;</td>
		<td><?php echo h($tag['Tag']['hits']); ?>&nbsp;</td>
        <td>
        <?php if($tag['Tag']['status'] == 1) { ?>
            <span class="publish"> <?php echo $this->Html->image("publish.png", array("alt" => "publish", 'url' => array('action' => 'unpublish', $tag['Tag']['id']))); ?></span>
        <?php }else { ?>
            <span class="unpublish"> <?php echo $this->Html->image("unpublish.png", array("alt" => "unpublish", 'url' => array('action' => 'publish', $tag['Tag']['id']))); ?></span>
        <?php } ?>
        </td>
		<td><?php echo h($tag['Tag']['created']); ?>&nbsp;</td>
		<td class="actions">
			<?php //echo $this->Html->link(__('View'), array('action' => 'view', $tag['Tag']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $tag['Tag']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $tag['Tag']['id']), null, __('Are you sure you want to delete # %s?', $tag['Tag']['name'])); ?>
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
	<ul>
		<li><?php echo $this->Html->link(__('New Tag'), array('action' => 'add')); ?></li>
	</ul>
</div>
