<?php

use Visiosoft\DropboxFieldType\Support\Config\RelatedHandler;

return [
    'related'    => [
        'required' => true,
        'type'     => 'anomaly.field_type.select',
        'config'   => [
            'handler' => RelatedHandler::class,
        ],
    ],
    'mode'       => [
        'required' => true,
        'type'     => 'anomaly.field_type.select',
        'config'   => [
            'options' => [
                'dropdown' => 'visiosoft.field_type.dropbox::config.mode.option.dropdown',
                'lookup'   => 'visiosoft.field_type.dropbox::config.mode.option.lookup',
                'search'   => 'visiosoft.field_type.dropbox::config.mode.option.search',
            ],
        ],
    ],
    'title_name' => [
        'type' => 'anomaly.field_type.text',
    ],
];
