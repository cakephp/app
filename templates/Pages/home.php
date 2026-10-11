<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.10.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Http\Exception\NotFoundException;

$this->disableAutoLayout();

if (!Configure::read('debug')) {
    throw new NotFoundException(
        'Please replace templates/Pages/home.php with your own version or re-enable debug mode.',
    );
}

$check = static function (string $label, string $status, string $detail, ?string $error = null): array {
    return compact('label', 'status', 'detail', 'error');
};
$checkConnection = static function (string $name): array {
    try {
        ConnectionManager::get($name)->getDriver()->connect();

        return ['connected' => true, 'error' => null];
    } catch (Throwable $exception) {
        $error = $exception->getMessage();
        if (method_exists($exception, 'getAttributes')) {
            $attributes = $exception->getAttributes();
            if (isset($attributes['message']) && is_string($attributes['message'])) {
                $error .= "\n" . $attributes['message'];
            }
        }

        return ['connected' => false, 'error' => $error];
    }
};
$cacheCheck = static function (string $name, string $label) use ($check): array {
    $settings = Cache::getConfig($name);

    return $check(
        $label,
        $settings ? 'success' : 'error',
        $settings ? $settings['className'] . ' engine configured.' : 'Configure this cache in config/app.php.',
    );
};

$environment = [
    $check('PHP', version_compare(PHP_VERSION, '8.5.0', '>=') ? 'success' : 'error',
        PHP_VERSION . ' detected. PHP 8.5.0 or higher required.'),
];
foreach (['mbstring', 'openssl', 'intl'] as $extension) {
    $loaded = extension_loaded($extension);
    $environment[] = $check($extension, $loaded ? 'success' : 'error',
        $loaded ? 'Extension loaded.' : 'Install and enable this PHP extension.');
}
$environment[] = $check('Development assertions', ini_get('zend.assertions') === '1' ? 'success' : 'warning',
    ini_get('zend.assertions') === '1' ? 'zend.assertions is enabled.' : 'Set zend.assertions to 1 in your php.ini.');

$filesystem = [];
foreach (['tmp' => TMP, 'logs' => LOGS] as $directory => $path) {
    $writable = is_writable($path);
    $filesystem[] = $check($directory . ' directory', $writable ? 'success' : 'error',
        $writable ? 'Writable.' : 'Give your web server write access to this directory.');
}
$filesystem[] = $cacheCheck('_cake_translations_', 'Translations cache');

$connection = $checkConnection('default');
$database = [
    $check('Default connection', $connection['connected'] ? 'success' : 'error',
        $connection['connected'] ? 'Connected to your database.' : 'Check Datasources in config/app_local.php.',
        $connection['error']),
    $cacheCheck('_cake_model_', 'Schema cache'),
];

$debugKitLoaded = Plugin::isLoaded('DebugKit');
$debugKit = [$check('Plugin', $debugKitLoaded ? 'success' : 'warning',
    $debugKitLoaded ? 'Loaded for development.' : 'Optional. Enable DebugKit in config/plugins.php.')];
if ($debugKitLoaded) {
    $connection = $checkConnection('debug_kit');
    $debugKit[] = $check('DebugKit connection', $connection['connected'] ? 'success' : 'error',
        $connection['connected'] ? 'Connected to its database.' : 'Check the DebugKit database configuration.',
        $connection['error']);
    if (!$connection['connected'] && !in_array('sqlite', PDO::getAvailableDrivers(), true)) {
        $debugKit[] = $check('SQLite driver', 'warning', 'Install pdo_sqlite to use the default DebugKit database.');
    }
}

$sections = [
    'environment' => ['title' => 'Environment', 'description' => 'Your PHP runtime and extensions.', 'checks' => $environment],
    'filesystem' => ['title' => 'Filesystem', 'description' => 'Writable directories and translation caching.', 'checks' => $filesystem],
    'database' => ['title' => 'Database', 'description' => 'Your application connection and schema cache.', 'checks' => $database],
    'debugkit' => ['title' => 'DebugKit', 'description' => 'A closer look at your application while you build.', 'checks' => $debugKit],
];
$statusLabels = ['success' => 'Passed', 'warning' => 'Review', 'error' => 'Failed'];
$resourceGroups = [
    'Community' => [
        ['Forum', 'https://discourse.cakephp.org/'],
        ['Slack', 'https://slack-invite.cakephp.org/'],
        ['Discord', 'https://discord.com/invite/k4trEMPebj'],
        ['Report an issue', 'https://github.com/cakephp/cakephp/issues'],
    ],
    'Ecosystem' => [
        ['Plugins', 'https://plugins.cakephp.org/'],
        ['Source code', 'https://github.com/cakephp/'],
        ['Awesome CakePHP', 'https://github.com/FriendsOfCake/awesome-cakephp'],
        ['Cake Software Foundation', 'https://cakefoundation.org/'],
    ],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light dark">
    <title><?= $this->fetch('title') ?: 'Welcome to CakePHP ' . h(Configure::version()) ?></title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css('cake') ?>
    <style>
        @layer welcome {
            .welcome {
                --glow-rose: light-dark(#d33c4329, #d33c433d);
                --glow-violet: light-dark(#7d85dd26, #7785ee33);
                --glow-amber: light-dark(#ffb98133, #fa976e26);
                --welcome-radius: 1rem;
                isolation: isolate;
                min-block-size: 100svh;
            }
            h1,
            h2,
            h3 {
                margin: 0;
                line-height: 1.2;
            }
            p,
            ul {
                margin: 0;
            }
            svg {
                display: block;
            }
            ::selection {
                background: color-mix(in srgb, var(--color-cakephp-red) 25%, transparent);
            }
            .ambient-background {
                position: fixed;
                inset: 0;
                z-index: -1;
                overflow: clip;
                pointer-events: none;
                &::before {
                    content: "";
                    position: absolute;
                    inset: -20%;
                    background:
                        radial-gradient(ellipse at 15% 18%, var(--glow-rose), transparent 52%),
                        radial-gradient(ellipse at 85% 25%, var(--glow-violet), transparent 55%),
                        radial-gradient(ellipse at 45% 90%, var(--glow-amber), transparent 55%);
                    transform-origin: 50% 30%;
                }
            }
            @keyframes ambient-drift {
                from {
                    transform: translate3d(-4%, -3%, 0) rotate(-3deg) scale(1);
                }
                to {
                    transform: translate3d(4%, 3%, 0) rotate(3deg) scale(1.08);
                }
            }
            @media (prefers-reduced-motion: no-preference) {
                .ambient-background::before {
                    animation: ambient-drift 24s ease-in-out infinite alternate;
                }
            }
            .shell {
                max-inline-size: 72rem;
                margin-inline: auto;
                padding-inline: clamp(1.25rem, 5vw, 3rem);
            }
            .hero {
                display: grid;
                grid-template-columns: minmax(0, 2fr) minmax(0, 1fr);
                align-items: center;
                gap: clamp(2rem, 5vw, 4rem);
                padding-block: clamp(3rem, 7vw, 5rem);
            }
            .hero-art {
                display: grid;
                place-items: center;
                align-self: center;
            }
            .cake-icon {
                inline-size: clamp(10.5rem, 21vw, 17rem);
                max-inline-size: 100%;
                block-size: auto;
                color: var(--color-cakephp-red);
            }
            .version {
                display: inline-block;
                padding: 0.2rem 0.7rem;
                border: 1px solid var(--color-border);
                border-radius: 100vmax;
                font-size: 0.8rem;
                color: var(--color-lightgray);
            }
            .hero h1 {
                margin-block: 1.25rem;
                font-size: clamp(2.5rem, 6vw, 4.5rem);
                letter-spacing: -0.055em;
                font-weight: 700;
            }
            .version-number {
                display: inline-block;
                font-size: 1.15em;
                line-height: 0.9;
                vertical-align: baseline;
                color: var(--color-links);
                background: linear-gradient(
                    135deg,
                    var(--color-links),
                    light-dark(#b6563c, #ffb789) 45%,
                    light-dark(#7952b3, #c3a1f7)
                );
                background-clip: text;
                -webkit-text-fill-color: transparent;
                transform: none;
                transform-origin: 50% 80%;
            }
            @keyframes version-pop {
                from {
                    opacity: 0;
                    transform: translateY(0.2em) rotate(-18deg) scale(0.75);
                }
                70% {
                    opacity: 1;
                    transform: rotate(3deg) scale(1.08);
                }
                to {
                    transform: none;
                }
            }
            @media (prefers-reduced-motion: no-preference) {
                .version-number {
                    animation: version-pop 700ms ease-out;
                    transition: transform 200ms ease-out;
                    &:hover {
                        transform: scale(1.08);
                    }
                }
            }
            .hero-copy > p {
                color: var(--color-lightgray);
                font-size: clamp(1rem, 2vw, 1.125rem);
                max-inline-size: 38rem;
                text-wrap: pretty;
            }
            .hero-actions {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                gap: 0.75rem;
                margin-block-start: 1.75rem;
            }
            .hero-link {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                padding-block: 0.75rem;
                margin-inline-start: 0.5rem;
                color: var(--color-lightgray);
                font-size: 0.9rem;
                text-decoration: none;
                &:hover {
                    text-decoration: underline;
                }
                & svg {
                    inline-size: 1.125rem;
                    block-size: 1.125rem;
                    flex-shrink: 0;
                }
            }
            .hero-actions .button {
                padding: 0.75rem 1.2rem;
                border-radius: 0.6rem;
                line-height: 1.6;
            }
            .section-heading {
                display: flex;
                flex-wrap: wrap;
                align-items: baseline;
                gap: 0.5rem 1rem;
                justify-content: space-between;
                margin-block-end: 1.25rem;
            }
            .section-heading h2 {
                font-size: 1.25rem;
                letter-spacing: -0.025em;
            }
            .section-heading p {
                color: var(--color-lightgray);
                font-size: 0.875rem;
            }
            .diagnostics {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 1rem;
            }
            .check-card {
                container-type: inline-size;
                background: var(--color-surface);
                border: 1px solid var(--color-border);
                border-radius: var(--welcome-radius);
                padding: clamp(1.25rem, 3vw, 1.75rem);
                & h3 {
                    font-size: 1.05rem;
                    letter-spacing: -0.02em;
                }
                & > p {
                    margin-block: 0.4rem 1.1rem;
                    color: var(--color-lightgray);
                    font-size: 0.8rem;
                }
            }
            .checks {
                list-style: none;
                padding: 0;
            }
            .check {
                display: grid;
                grid-template-columns: minmax(0, 1fr) auto;
                gap: 0.2rem 1rem;
                padding-block: 0.85rem;
                border-block-start: 1px solid var(--color-border);
                font-size: 0.875rem;
                & strong {
                    font-weight: 600;
                }
                & > p,
                & details {
                    grid-column: 1 / -1;
                    color: var(--color-lightgray);
                    font-size: 0.8rem;
                }
            }
            .status {
                display: inline-flex;
                align-items: center;
                gap: 0.3rem;
                color: var(--color-message-success-text);
                font-size: 0.75rem;
                font-weight: 600;
                &[data-status="warning"] {
                    color: var(--color-message-warning-text);
                }
                &[data-status="error"] {
                    color: var(--color-message-error-text);
                }
                & svg {
                    inline-size: 0.95rem;
                    block-size: 0.95rem;
                    flex-shrink: 0;
                }
            }
            details {
                margin-block-start: 0.5rem;
                & summary {
                    cursor: pointer;
                    color: var(--color-links);
                    inline-size: fit-content;
                }
                & pre {
                    white-space: pre-wrap;
                    overflow-wrap: anywhere;
                    margin-block: 0.65rem 0;
                    padding: 0.75rem;
                    border-radius: 0.4rem;
                    background: var(--color-main-bg);
                    font-size: 0.75rem;
                }
            }
            .card-help {
                border-block-start: 1px solid var(--color-border);
                padding-block-start: 0.85rem;
                color: var(--color-lightgray);
                font-size: 0.8rem;
            }
            .development-note {
                display: grid;
                grid-template-columns: minmax(0, 1fr) minmax(0, 3fr);
                align-items: baseline;
                gap: 0.75rem 2rem;
                margin-block: 1rem 2rem;
                padding: clamp(1.25rem, 3vw, 1.75rem);
                background: var(--color-surface);
                border: 1px solid var(--color-border);
                border-radius: var(--welcome-radius);
                color: var(--color-lightgray);
                font-size: 0.875rem;
                & h2 {
                    font-size: 1rem;
                    color: var(--color-text);
                }
                & p + p {
                    margin-block-start: 0.375rem;
                }
                & .note-meta {
                    font-size: 0.8rem;
                }
                & code {
                    color: var(--color-text);
                }
            }
            .resources {
                display: grid;
                gap: 1.25rem;
                padding-block: 2rem;
                & h2 {
                    font-size: 0.875rem;
                }
                & ul {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 0.5rem 1.5rem;
                    padding: 0;
                    list-style: none;
                }
                & a {
                    color: var(--color-lightgray);
                    text-decoration: none;
                    font-size: 0.875rem;
                }
                & a:hover {
                    color: var(--color-links);
                    text-decoration: underline;
                }
            }
            .resource-group {
                display: grid;
                grid-template-columns: 7rem minmax(0, 1fr);
                align-items: baseline;
                gap: 0.5rem 1.5rem;
            }
            .site-footer {
                border-block-start: 1px solid var(--color-border);
            }
            .footer-meta {
                display: flex;
                flex-wrap: wrap;
                gap: 0.5rem 1.5rem;
                justify-content: space-between;
                padding-block: 1.25rem 2rem;
                color: var(--color-lightgray);
                font-size: 0.75rem;
                border-block-start: 1px solid var(--color-border);
            }
            .cake-error {
                margin-block: 1rem;
                padding: 1rem;
                border: 1px solid var(--color-message-error-text);
                border-radius: 0.5rem;
                overflow-wrap: anywhere;
            }
            @media (width < 56rem) {
                .hero {
                    grid-template-columns: minmax(0, 1fr) auto;
                    gap: 0 1rem;
                }
                .hero-copy {
                    display: contents;
                    & > :not(.version) {
                        grid-column: 1 / -1;
                    }
                }
                .version {
                    justify-self: start;
                    align-self: center;
                }
                .hero-art {
                    grid-column: 2;
                    grid-row: 1;
                }
                .cake-icon {
                    inline-size: clamp(4rem, 14vw, 7rem);
                }
            }
            @media (width < 44rem) {
                .diagnostics {
                    grid-template-columns: minmax(0, 1fr);
                }
                .resource-group {
                    grid-template-columns: minmax(0, 1fr);
                }
                .development-note {
                    grid-template-columns: minmax(0, 1fr);
                }
            }
            @container (width < 17rem) {
                .check {
                    grid-template-columns: minmax(0, 1fr);
                }
                .status {
                    grid-row: 2;
                }
            }
            @media (forced-colors: active) {
                .ambient-background {
                    display: none;
                }
                .version-number {
                    background: none;
                    color: CanvasText;
                    -webkit-text-fill-color: currentColor;
                }
                .check-card,
                .development-note,
                .version {
                    border-color: CanvasText;
                }
            }
        }
    </style>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body class="welcome">
    <div class="ambient-background" aria-hidden="true"></div>
    <a class="skip-link" href="#main">Skip to content</a>
    <div class="shell">
        <main id="main">
            <section class="hero" aria-labelledby="welcome-heading">
                <div class="hero-copy">
                    <span class="version">CakePHP <?= h(Configure::version()) ?></span>
                    <h1 id="welcome-heading">Welcome to CakePHP <span class="version-number">6</span></h1>
                    <p>A fresh start for your next idea. Everything you need to build a powerful application, with conventions that keep you moving.</p>
                    <div class="hero-actions">
                        <a class="button" href="https://book.cakephp.org/6.x/" target="_blank" rel="noopener">Read the documentation <span aria-hidden="true">↗</span></a>
                        <a class="button button-secondary" href="https://book.cakephp.org/6.x/tutorials-and-examples/cms/installation.html" target="_blank" rel="noopener">Build your first app <span aria-hidden="true">↗</span></a>
                        <a class="hero-link" href="https://github.com/cakephp/cakephp" target="_blank" rel="noopener">
                            <!-- GitHub mark from Octicons (MIT), copyright GitHub, Inc. -->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="18" height="18" fill="currentColor" aria-hidden="true" focusable="false">
                                <path d="M6.766 11.328c-2.063-.25-3.516-1.734-3.516-3.656 0-.781.281-1.625.75-2.188-.203-.515-.172-1.609.063-2.062.625-.078 1.468.25 1.968.703.594-.187 1.219-.281 1.985-.281.765 0 1.39.094 1.953.265.484-.437 1.344-.765 1.969-.687.218.422.25 1.515.046 2.047.5.593.766 1.39.766 2.203 0 1.922-1.453 3.375-3.547 3.64.531.344.89 1.094.89 1.954v1.625c0 .468.391.734.86.547C13.781 14.359 16 11.53 16 8.03 16 3.61 12.406 0 7.984 0 3.563 0 0 3.61 0 8.031a7.88 7.88 0 0 0 5.172 7.422c.422.156.828-.125.828-.547v-1.25c-.219.094-.5.156-.75.156-1.031 0-1.64-.562-2.078-1.609-.172-.422-.36-.672-.719-.719-.187-.015-.25-.093-.25-.187 0-.188.313-.328.625-.328.453 0 .844.281 1.25.86.313.452.64.655 1.031.655s.641-.14 1-.5c.266-.265.47-.5.657-.656" />
                            </svg>
                            GitHub <span aria-hidden="true">↗</span>
                        </a>
                    </div>
                </div>
                <div class="hero-art" aria-hidden="true">
                    <svg class="cake-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 58 45.258" width="272" height="212" fill="currentColor" aria-hidden="true" focusable="false">
                        <path d="M28.993,18.11l22.685,5.632c3.948-1.541,6.318-3.505,6.318-5.632V9.052C57.996,4.058,45.011,0,28.993,0C12.979,0,0,4.058,0,9.052v9.058c0,4.995,12.979,9.05,28.993,9.05V18.11z" />
                        <path d="M51.676,32.796L28.993,27.16v9.051l22.683,5.638c3.95-1.549,6.322-3.504,6.322-5.638V27.16C57.999,29.292,55.626,31.25,51.676,32.796" />
                        <path d="M0,27.16v9.052c0,4.996,12.979,9.047,28.993,9.047v-9.047C12.979,36.211,0,32.155,0,27.16" />
                    </svg>
                </div>
            </section>
            <section aria-labelledby="setup-heading">
                <div class="section-heading">
                    <h2 id="setup-heading">Your development setup</h2>
                    <p>A few checks before you get started.</p>
                </div>
                <div class="diagnostics">
                    <?php foreach ($sections as $id => $section) : ?>
                    <section class="check-card" aria-labelledby="<?= h($id) ?>-heading">
                        <h3 id="<?= h($id) ?>-heading"><?= h($section['title']) ?></h3>
                        <p><?= h($section['description']) ?></p>
                        <ul class="checks">
                            <?php foreach ($section['checks'] as $item) : ?>
                            <li class="check">
                                <strong><?= h($item['label']) ?></strong>
                                <span class="status" data-status="<?= h($item['status']) ?>">
                                    <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <?php if ($item['status'] === 'success') : ?>
                                        <path d="m3 8 3 3 7-7" />
                                        <?php elseif ($item['status'] === 'warning') : ?>
                                        <path d="m8 2 6 12H2L8 2Z M8 6v3 M8 11v.1" />
                                        <?php else : ?>
                                        <circle cx="8" cy="8" r="6" /><path d="m6 6 4 4 M10 6l-4 4" />
                                        <?php endif; ?>
                                    </svg>
                                    <?= h($statusLabels[$item['status']]) ?>
                                </span>
                                <p><?= h($item['detail']) ?></p>
                                <?php if ($item['error'] !== null) : ?>
                                <details>
                                    <summary>Connection details</summary>
                                    <pre><?= h($item['error']) ?></pre>
                                </details>
                                <?php endif; ?>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                        <?php if ($id === 'debugkit') : ?>
                        <p class="card-help">Toolbar not showing? Check <a href="https://book.cakephp.org/debugkit/" target="_blank" rel="noopener">DebugKit configuration</a>, including <code>DebugKit.safeTld</code>.</p>
                        <?php endif; ?>
                    </section>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php Debugger::checkSecurityKeys(); ?>
            <aside class="development-note" aria-labelledby="customize-heading">
                <h2 id="customize-heading">Make this page yours</h2>
                <div>
                    <p>Replace <code>templates/Pages/home.php</code> with your own welcome page when you are ready.</p>
                    <p class="note-meta">This page is only available while debug mode is enabled.</p>
                </div>
            </aside>
        </main>
        <footer class="site-footer">
            <nav class="resources" aria-label="Explore CakePHP">
                <?php foreach ($resourceGroups as $title => $links) : ?>
                <div class="resource-group">
                    <h2><?= h($title) ?></h2>
                    <ul>
                        <?php foreach ($links as [$label, $url]) : ?>
                        <li><a href="<?= h($url) ?>" target="_blank" rel="noopener"><?= h($label) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endforeach; ?>
            </nav>
            <div class="footer-meta">
                <p>Built with CakePHP.</p>
                <p>Need help with setup? <a href="https://book.cakephp.org/6.x/installation.html#url-rewriting" target="_blank" rel="noopener">URL rewriting</a> · <a href="https://book.cakephp.org/6.x/development/configuration.html#general-configuration" target="_blank" rel="noopener">Configuration</a></p>
            </div>
        </footer>
    </div>
</body>
</html>
