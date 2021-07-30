<?php

return [
    // copy this part into config('admin.extensions') if u want to override
    'impersonate' => [
        'dialogs' => [
            'impersonate' => [
                'position' => 'center-right',
            ],
        ],
        'session_keys' => [
            'impersonator' => 'impersonator',
        ]
    ],
];
