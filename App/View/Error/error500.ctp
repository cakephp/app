<?php
use Cake\Core\Configure;
?>
<h2><?= $message; ?></h2>
<p class="error">
	<strong><?= __d('cake', 'Error'); ?>: </strong>
	<?= __d('cake', 'An Internal Error Has Occurred.'); ?>
</p>
<?php
if (Configure::read('debug') > 0):
	echo $this->element('exception_stack_trace');
endif;
?>
