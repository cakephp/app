<?php
/**
 * @var \App\View\AppView $this
 * @var array $params
 * @var string $message
 */
$class = 'message';
if (!empty($params['class'])) {
    $class .= ' ' . $params['class'];
}
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="<?= h($class) ?>" role="status">
    <button type="button" class="message-dismiss" aria-label="<?= h(__('Dismiss message')) ?>" onclick="this.closest('.message').classList.add('hidden');"><span aria-hidden="true">×</span></button>
    <?= $message ?>
</div>
