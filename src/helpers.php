<?php

use Hmimeee\Revolut\Revolut;

if (!function_exists('getRevolut')) {
    /**
     * Get the Revolut instance
     * 
     * @param array $config A config array such as `['env' => 'live' //or sandbox (default), 'key' => 'Key here']`
     * @return \Hmimeee\Revolut
     */
    function getRevolut(array $config)
    {
        $config = array_merge([
            'env' => 'sandbox',
            'key' => 'Test key here'
        ], $config);

        return Revolut::instance()->setEnvironment($config['env'])->setKey($config['key']);
    }
}
