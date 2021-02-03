<div class="categories index">
    <h2><?php echo __('List Categories'); ?></h2>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php echo $this->Paginator->sort('id', '#'); ?></th>
            <th><?php echo $this->Paginator->sort('name'); ?></th>
            <th><?php echo $this->Paginator->sort('alias'); ?></th>
            <th><?php echo $this->Paginator->sort('Publish'); ?></th>
            <th><?php echo $this->Paginator->sort('created'); ?></th>
            <th class="actions"></th>
        </tr>
        <?php foreach ($categories as $category): ?>
            <tr>
                <td><?php echo h($category['Category']['id']); ?>&nbsp;</td>
                <td><?php echo h($category['Category']['name']); ?>&nbsp;</td>
                <td><?php echo h($category['Category']['alias']); ?>&nbsp;</td>
                <td>
                <?php if($category['Category']['status'] == 1) { ?>
                    <span class="publish"> <?php echo $this->Html->image("publish.png", array("alt" => "publish", 'url' => array('action' => 'unpublish', $category['Category']['id']))); ?></span>
                <?php }else { ?>
                    <span class="unpublish"> <?php echo $this->Html->image("unpublish.png", array("alt" => "unpublish", 'url' => array('action' => 'publish', $category['Category']['id']))); ?></span>
                <?php } ?>
                </td>
                <td><?php echo h($category['Category']['created']); ?>&nbsp;</td>
                <td class="actions" style="text-align: left">
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $category['Category']['id'])); ?>
                    <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $category['Category']['id']), null, __('Are you sure you want to delete # %s?', $category['Category']['id'])); ?>
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
        <li><?php echo $this->Html->link(__('Add Category'), array('action' => 'add')); ?></li>
        <li><?php echo $this->Html->link(__('List Sources'), array('controller' => 'sources', 'action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('RSS URL'), array('controller' => 'sourcesrss', 'action' => 'index')); ?> </li>
    </ul>
</div>
