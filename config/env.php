<?php
use Cake\Utility\Hash;
use josegonzalez\Dotenv\Loader;

$config = [];
if (!env('APP_NAME')) {
    $dotenv = new Loader([
        __DIR__ . DS . '.env',
        __DIR__ . DS . '.env.default',
    ]);
    $dotenv->setFilters([
        'josegonzalez\Dotenv\Filter\LowercaseKeyFilter',
        'josegonzalez\Dotenv\Filter\UppercaseFirstKeyFilter',
        'josegonzalez\Dotenv\Filter\UnderscoreArrayFilter',
        function ($data) {
            $keys = [
                'App.fullbaseurl' => 'App.fullBaseUrl',
                'Debug' => 'debug',
                'Email.transport' => 'EmailTransport',
                'Database.debug.kit' => 'Datasources.debug_kit',
                'Database.test' => 'Datasources.test',
                'Database' => 'Datasources.default',
                'Cache.duration' => null,
                'Cache.cakemodel' => 'Cache._cake_model_',
                'Cache.cakecore' => 'Cache._cake_core_',
            ];
            foreach ($keys as $key => $newKey) {
                if ($newKey === null) {
                    $data = Hash::remove($data, $key);
                    continue;
                }
                $value = Hash::get($data, $key);
                $data = Hash::remove($data, $key);
                if ($value !== null) {
                    $data = Hash::insert($data, $newKey, $value);
                }
            }

            foreach ($data['Email'] as $key => $config) {
                if (isset($config['profile'])) {
                    parse_str($config['profile'], $output);
                    $data['Email'][$key] = array_merge($output, $data['Email'][$key]);
                    unset($data['Email'][$key]['profile'], $output);
                }
            }

            return $data;
        }
    ]);
    $dotenv->parse();
    $dotenv->filter();
    $config = $dotenv->toArray();
}

return $config;
