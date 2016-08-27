<?php
$class = 'message';
if (!empty($params['class'])) {
    $class .= ' ' . $params['class'];
}
?>
<div class="<?= h($class) ?>" onclick="this.classList.add('hidden');"><?= h($message) ?></div>
