<?php
/**
 * @var \App\View\AppView $this
 * @var array $params
 * @var string $message
 */
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="message success" role="status">
    <button type="button" class="message-dismiss" aria-label="<?= h(__('Dismiss message')) ?>" onclick="this.closest('.message').classList.add('hidden');"><span aria-hidden="true">×</span></button>
    <?= $message ?>
</div>
