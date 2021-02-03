<div class="categories view">
<h2><?php echo __('Category'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($category['Category']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($category['Category']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Alias'); ?></dt>
		<dd>
			<?php echo h($category['Category']['alias']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('State'); ?></dt>
		<dd>
			<?php echo h($category['Category']['state']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Metakey'); ?></dt>
		<dd>
			<?php echo h($category['Category']['metakey']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Metadesc'); ?></dt>
		<dd>
			<?php echo h($category['Category']['metadesc']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($category['Category']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Category'), array('action' => 'edit', $category['Category']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Category'), array('action' => 'delete', $category['Category']['id']), null, __('Are you sure you want to delete # %s?', $category['Category']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Categories'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Contents'), array('controller' => 'contents', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content'), array('controller' => 'contents', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sources Rsses'), array('controller' => 'sources_rss', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sources Rss'), array('controller' => 'sources_rss', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Contents'); ?></h3>
	<?php if (!empty($category['Content'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Title'); ?></th>
		<th><?php echo __('Alias'); ?></th>
		<th><?php echo __('Content'); ?></th>
		<th><?php echo __('State'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Category Id'); ?></th>
		<th><?php echo __('Source Id'); ?></th>
		<th><?php echo __('Original Link'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($category['Content'] as $content): ?>
		<tr>
			<td><?php echo $content['id']; ?></td>
			<td><?php echo $content['title']; ?></td>
			<td><?php echo $content['alias']; ?></td>
			<td><?php echo $content['content']; ?></td>
			<td><?php echo $content['state']; ?></td>
			<td><?php echo $content['created']; ?></td>
			<td><?php echo $content['category_id']; ?></td>
			<td><?php echo $content['source_id']; ?></td>
			<td><?php echo $content['original_link']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'contents', 'action' => 'view', $content['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'contents', 'action' => 'edit', $content['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'contents', 'action' => 'delete', $content['id']), null, __('Are you sure you want to delete # %s?', $content['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Content'), array('controller' => 'contents', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Sources Rsses'); ?></h3>
	<?php if (!empty($category['SourcesRss'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Link'); ?></th>
		<th><?php echo __('Rss Link'); ?></th>
		<th><?php echo __('Source Id'); ?></th>
		<th><?php echo __('Category Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($category['SourcesRss'] as $sourcesRss): ?>
		<tr>
			<td><?php echo $sourcesRss['id']; ?></td>
			<td><?php echo $sourcesRss['link']; ?></td>
			<td><?php echo $sourcesRss['rss_link']; ?></td>
			<td><?php echo $sourcesRss['source_id']; ?></td>
			<td><?php echo $sourcesRss['category_id']; ?></td>
			<td><?php echo $sourcesRss['created']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'sources_rsses', 'action' => 'view', $sourcesRss['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'sources_rsses', 'action' => 'edit', $sourcesRss['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'sources_rsses', 'action' => 'delete', $sourcesRss['id']), null, __('Are you sure you want to delete # %s?', $sourcesRss['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Sources Rss'), array('controller' => 'sources_rsses', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
