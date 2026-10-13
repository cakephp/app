<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Test\TestCase\Mailer;

use Cake\Mailer\Message;
use Cake\Mailer\Renderer;
use Cake\TestSuite\TestCase;

/**
 * Tests the default email templates in templates/email.
 */
class DefaultTemplateTest extends TestCase
{
    /**
     * Render content with the default HTML template, without a layout.
     *
     * @param string $content The content.
     * @return string
     */
    protected function renderHtml(string $content): string
    {
        $renderer = new Renderer();
        $renderer->viewBuilder()
            ->setTemplate('default')
            ->disableAutoLayout();

        return $renderer->render($content, [Message::MESSAGE_HTML])[Message::MESSAGE_HTML];
    }

    /**
     * Test blank lines separate paragraphs and single line breaks become <br>.
     *
     * @return void
     */
    public function testHtmlParagraphs(): void
    {
        $html = $this->renderHtml("First line\r\nsecond line\r\n\r\n\r\nNext paragraph\n");

        $this->assertSame(
            '<p>First line<br>second line</p><p>Next paragraph</p>',
            preg_replace('/>\s+</', '><', trim($html)),
        );
    }

    /**
     * Test the content is escaped.
     *
     * @return void
     */
    public function testHtmlEscapesContent(): void
    {
        $html = $this->renderHtml('<script>alert("x")</script> & more');

        $this->assertStringContainsString('&lt;script&gt;alert(&quot;x&quot;)&lt;/script&gt; &amp; more', $html);
        $this->assertStringNotContainsString('<script>', $html);
    }

    /**
     * Test multibyte characters containing the byte 0x85 are not split as line breaks.
     *
     * @return void
     */
    public function testHtmlKeepsMultibyteCharacters(): void
    {
        $html = $this->renderHtml("Ångström\nĽahký kôň žerie ďatelinu");

        $this->assertSame('<p>Ångström<br>Ľahký kôň žerie ďatelinu</p>', trim($html));
    }

    /**
     * Test empty content renders no paragraphs.
     *
     * @return void
     */
    public function testHtmlEmptyContent(): void
    {
        $this->assertStringNotContainsString('<p>', $this->renderHtml(" \r\n\r\n "));
    }
}
