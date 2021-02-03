<div class="categories form">
    <?php echo $this->Form->create('Category'); ?>
    <fieldset>
        <legend>
        <?php 
            if($this->request->params['action'] == 'cpadmin_edit') {
                echo __('Edit Category');
            }else {
                echo __('Add Category');
            }
        ?>
        </legend>
        <?php
        echo $this->Form->hidden('id');
        echo $this->Form->input('name');
        echo $this->Form->input('alias');
        echo $this->Form->input('status', array(
            'options'=> array(
                '0' => __('UnPublish'),
                '1' => __('Publish'),
            ),
            'default'=> '1'
        ));
        echo $this->Form->input('metakey');
        echo $this->Form->input('metadesc');
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Save')); ?>
</div>
<div class="actions">
    <ul>
        <li><?php echo $this->Html->link(__('List Categories'), array('action' => 'index')); ?></li>
        <li><?php echo $this->Html->link(__('List Sources'), array('controller' => 'sources', 'action' => 'index')); ?></li>
        <li><?php echo $this->Html->link(__('List Sources'), array('controller' => 'sourcesrss', 'action' => 'index')); ?> </li>
    </ul>
</div>

<script>
$( document ).ready(function() {
    $("#CategoryName").keyup(function(){
            var Text = $(this).val();
            Text = Text.toLowerCase();
            var regExp = /\s+/g;
			Text = Text.trim();
            Text = Text.replace(regExp,'-');
            $("#CategoryAlias").val(Text);        
    });
});

</script>