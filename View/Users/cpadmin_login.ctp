<center>
<br />
<div style="background: #f4eddd; width: 50%; text-align: right;" >
<?php echo $this->Form->create('User', array('action' => 'login')); ?>
<fieldset>
    <!--<legend style="background: #f4eddd"><?php echo __('Login'); ?></legend>-->
    <?php echo $this->Session->flash('auth'); ?>
    <?php
        echo $this->Form->input('username');
        echo $this->Form->input('password');
    ?>
    <input type="submit" value="<?php echo __('Login'); ?>">
</fieldset>
    <?php echo $this->Form->end(); ?>
</div>
</center>