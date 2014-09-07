<?php
use Cake\Core\Configure;
?>
<h2><?= __d('cake', 'An Internal Error Has Occurred') ?></h2>
<p class="error">
	<strong><?= __d('cake', 'Error') ?>: </strong>
	<?= h($message) ?>
</p>
<?php
if (Configure::read('debug')):
	echo $this->element('auto_table_warning');
	echo $this->element('exception_stack_trace');
endif;
?>
