<div class="sourcesRsses form">
    <?php echo $this->Form->create('SourcesRss'); ?>
    <fieldset>
        <legend>
            <?php
            if ($this->request->params['action'] == 'cpadmin_edit') {
                echo __('Cpadmin Edit Sources Rss');
            } else {
                echo __('Cpadmin Add Sources Rss');
            }
            ?>
        </legend>
        <?php
        echo $this->Form->hidden('id');
        echo $this->Form->input('link');
        echo $this->Form->input('source_id');
//        echo $this->Form->input('category_id');
        echo $this->Form->input('country_id');
        echo $this->Form->input('status', array(
            'options' => array(
                '0' => __('UnPublish'),
                '1' => __('Publish'),
            ),
            'default' => '1'
        ));
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Save')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('List Sources Rsses'), array('action' => 'index')); ?></li>
        <li><?php echo $this->Html->link(__('List Sources'), array('controller' => 'sources', 'action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New Source'), array('controller' => 'sources', 'action' => 'add')); ?> </li>
        <li><?php echo $this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
    </ul>
</div>
