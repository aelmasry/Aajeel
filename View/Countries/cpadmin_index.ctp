<div class="categories index">
    <h2><?php echo __('List Countries'); ?></h2>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php echo $this->Paginator->sort('id', '#'); ?></th>
            <th><?php echo $this->Paginator->sort('name'); ?></th>
            <th><?php echo $this->Paginator->sort('Publish'); ?></th>
            <th><?php echo $this->Paginator->sort('created'); ?></th>
            <th class="actions"></th>
        </tr>
        <?php foreach ($countries as $country): ?>
            <tr>
                <td><?php echo h($country['Country']['id']); ?>&nbsp;</td>
                <td><?php echo h($country['Country']['name']); ?>&nbsp;</td>
                <td>
                <?php if($country['Country']['status'] == 1) { ?>
                    <span class="publish"> <?php echo $this->Html->image("publish.png", array("alt" => "publish", 'url' => array('action' => 'unpublish', $country['Country']['id']))); ?></span>
                <?php }else { ?>
                    <span class="unpublish"> <?php echo $this->Html->image("unpublish.png", array("alt" => "unpublish", 'url' => array('action' => 'publish', $country['Country']['id']))); ?></span>
                <?php } ?>
                </td>
                <td><?php echo h($country['Country']['created']); ?>&nbsp;</td>
                <td class="actions" style="text-align: left">
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $country['Country']['id'])); ?>
                    <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $country['Country']['id']), null, __('Are you sure you want to delete # %s?', $country['Country']['name'])); ?>
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
        <li><?php echo $this->Html->link(__('New country'), array('action' => 'add')); ?></li>
        <li><?php echo $this->Html->link(__('List Sources'), array('controller' => 'sources', 'action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New source'), array('controller' => 'sources', 'action' => 'add')); ?> </li>
    </ul>
</div>
