<div class="categories form">
    <?php echo $this->Form->create('Country'); ?>
    <fieldset>
        <legend>
        <?php 
            if($this->request->params['action'] == 'cpadmin_edit') {
                echo __('Edit country');
            }else {
                echo __('Add country');
            }
        ?>
        </legend>
        <?php
        echo $this->Form->hidden('id');
        echo $this->Form->input('name');
        echo $this->Form->input('alias');
        echo $this->Form->input('code');
		echo $this->Form->input('order', array('type'=>'number'));
        echo $this->Form->input('status', array(
            'options'=> array(
                '0' => __('No'),
                '1' => __('Yes'),
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
        <li><?php echo $this->Html->link(__('List countries'), array('action' => 'index')); ?></li>
        <li><?php echo $this->Html->link(__('List Sources'), array('controller' => 'sources', 'action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New source'), array('controller' => 'sources', 'action' => 'add')); ?> </li>
    </ul>
</div>
<!--
<script>
$( document ).ready(function() {
    $("#CountryName").keyup(function(){
            var Text = $(this).val();
            Text = Text.toLowerCase();
            var regExp = /\s+/g;
			Text = Text.trim();
            Text = Text.replace(regExp,'-');
            $("#CountryAlias").val(Text);        
    });
});

</script>
-->