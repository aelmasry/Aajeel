<div class="tags form">
<?php echo $this->Form->create('Tag'); ?>
	<fieldset>
        <legend>
        <?php
        if ($this->request->params['action'] == 'cpadmin_edit') {
            echo __('Cpadmin Edit Tag');
        } else {
            echo __('Cpadmin Add Tag');
        }
        ?>
        </legend>
	<?php
        echo $this->Form->hidden('id');
		echo $this->Form->input('name');
		echo $this->Form->input('alias');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Save')); ?>
</div>
<div class="actions">
	<ul>
	<li><?php echo $this->Html->link(__('List Tags'), array('action' => 'index')); ?></li>
	</ul>
</div>
<script>
    
$( document ).ready(function() {
    $("#TagName").keyup(function(){
		var Text = $(this).val();
		Text = Text.toLowerCase();
		var regExp = /\s+/g;
		Text = Text.trim();
		Text = Text.replace(regExp,'-');
		$("#TagAlias").val(Text);        
    });
});

</script>