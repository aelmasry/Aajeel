<a href="<?php echo $this->Html->url(array('controller' => 'categories', 'action' => 'index', 'cpadmin' => TRUE)); ?>" class="dashboard-module">
    <img src="<?php echo $this->request->webroot ?>img/Crystal_Clear_files.gif" width="64" height="64" alt="edit" />
    <span><?php echo __('categories') ?></span>
</a>
<a href="<?php echo $this->Html->url(array('controller' => 'countries', 'action' => 'index', 'cpadmin' => TRUE)); ?>" class="dashboard-module">
    <img src="<?php echo $this->request->webroot ?>img/Crystal_Clear_files.gif" width="64" height="64" alt="edit" />
    <span><?php echo __('countries') ?></span>
</a>

<a href="<?php echo $this->Html->url(array('controller' => 'sources', 'action' => 'index', 'cpadmin' => TRUE)); ?>" class="dashboard-module">
    <img src="<?php echo $this->request->webroot ?>img/Crystal_Clear_files.gif" width="64" height="64" alt="edit" />
    <span><?php echo __('sources') ?></span>
</a>

<a href="<?php echo $this->Html->url(array('controller' => 'sourcesRss', 'action' => 'index', 'cpadmin' => TRUE)); ?>" class="dashboard-module">
    <img src="<?php echo $this->request->webroot ?>img/Crystal_Clear_files.gif" width="64" height="64" alt="edit" />
    <span><?php echo __('RSS URL') ?></span>
</a>

<a href="<?php echo $this->Html->url(array('controller' => 'tags', 'action' => 'index', 'cpadmin' => TRUE)); ?>" class="dashboard-module">
    <img src="<?php echo $this->request->webroot ?>img/Crystal_Clear_files.gif" width="64" height="64" alt="edit" />
    <span><?php echo __('Tags') ?></span>
</a>

<a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'index', 'cpadmin' => TRUE)); ?>" class="dashboard-module">
    <img src="<?php echo $this->request->webroot ?>img/Crystal_Clear_files.gif" width="64" height="64" alt="edit" />
    <span><?php echo __('Users') ?></span>
</a>


<div style="clear: both"></div>