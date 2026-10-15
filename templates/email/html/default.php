<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \Cake\View\View $this
 * @var string $content
 */

// $content is plain text: blank lines separate paragraphs and single line breaks become <br>.
// (*BSR_ANYCRLF) limits \R to CR and LF; without /u it would also match the byte 0x85 inside UTF-8 characters such as "Å".
?>
<?php foreach (preg_split('/(*BSR_ANYCRLF)\R\s*\R/', trim($content)) ?: [] as $paragraph) : ?>
    <?php if ($paragraph !== '') : ?>
        <p><?= implode('<br>', array_map(h(...), preg_split('/(*BSR_ANYCRLF)\R/', $paragraph) ?: [])) ?></p>
    <?php endif; ?>
<?php endforeach; ?>
