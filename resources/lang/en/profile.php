<?php

return [
    'account' => 'Account',
    'profile' => 'Profile',
    'my_profile' => 'My Profile',
    'personal_info' => [
        'heading' => 'Personal Information',
        'subheading' => 'Manage your personal information.',
        'submit' => [
            'label' => 'Save',
        ],
        'notify' => 'Profile updated successfully!',
    ],
    'password' => [
        'heading' => 'Password',
        'subheading' => 'Must be 8 characters.',
        'submit' => [
            'label' => 'Save',
        ],
        'notify' => 'Password updated successfully!',
    ],

    'two_factor' => [
        'title' => 'Two Factor Authentication',
        'description' => 'Add additional security to your account using two factor authentication.',
    ],

    'sanctum' => [
        'title' => 'API Tokens',
        'description' => 'Manage API tokens that allow third-party services to access this application on your behalf. NOTE: your token is shown once upon creation. If you lose your token, you will need to delete it and create a new one.',
        'create' => [
            'notify' => 'Token created successfully!',
            'submit' => [
                'label' => 'Create',
            ],
        ],
        'update' => [
            'notify' => 'Token updated successfully!',
        ],
    ],

    'account_deletion' => [
        'title' => 'Delete Account',
        'description' => 'Permanently delete your account.',
        'content' => 'Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.',
        'modal' => [
            'description' => 'Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.'
        ],
        'notify' => 'Account deleted successfully!',
    ]
];
