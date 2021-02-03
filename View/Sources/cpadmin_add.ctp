<div class="sources form">
    <?php echo $this->Form->create('Source', array('type' => 'file')); ?>
    <fieldset>
        <legend>
        <?php
            if ($this->request->params['action'] == 'cpadmin_edit') {
                echo __('Edit Source');
            } else {
                echo __('Add Source');
            }
        ?>
        </legend>
        <?php
        echo $this->Form->hidden('id');
        echo $this->Form->input('name');
        echo $this->Form->input('alias');
        echo $this->Form->input('domain', array('required', 'placeholder'=> 'http://www.example.com'));
        echo $this->Form->input('metakey');
        echo $this->Form->input('metadesc');
        echo $this->Form->input('country_id');
        echo $this->Form->input('status', array(
            'options' => array(
                '0' => __('No'),
                '1' => __('Yes'),
            ),
            'default' => '1'
        ));

        if ($this->request->params['action'] == 'cpadmin_add') {
            $required = true;
        } else {
            $required = FALSE;
        }
        
        echo $this->Form->input('logo', array('type' => 'file', 'required' => $required));
        
        ?>
        <fieldset>
            <legend> XML params </legend>
            <?php echo $this->Form->input('Source.xml.title'); ?>
            <?php echo $this->Form->input('Source.xml.permalink'); ?>
            <?php echo $this->Form->input('Source.xml.content'); ?>
            <?php echo $this->Form->input('Source.xml.image'); ?>
            <?php echo $this->Form->input('Source.xml.publish_up'); ?>
        </fieldset>
        
        <fieldset>
            <legend> HTML params </legend>
            <?php echo $this->Form->input('Source.html.title'); ?>
            <?php echo $this->Form->input('Source.html.permalink'); ?>
            <?php echo $this->Form->input('Source.html.imagesrc'); ?>
            <?php echo $this->Form->input('Source.html.imagealt'); ?>
            <?php echo $this->Form->input('Source.html.content'); ?>
            <?php echo $this->Form->input('Source.html.publish_up'); ?>
        </fieldset>
    
    </fieldset>
    
    <?php echo $this->Form->end(__('Save')); ?>
</div>
<div class="actions">
    <ul>
        <li><?php echo $this->Html->link(__('List Sources'), array('action' => 'index')); ?></li>
        <li><?php echo $this->Html->link(__('List countries'), array('controller'=> 'categories', 'action' => 'index')); ?></li>
    </ul>
</div>

<script>
    $(document).ready(function() {
        $("#SourceName").keyup(function() {
            var Text = $(this).val();
            Text = Text.toLowerCase();
            var regExp = /\s+/g;
            Text = Text.replace(regExp, '-');
            $("#SourceAlias").val(Text);
        });
    });
</script>