<?php
namespace Mostad\SocialGrant;

use Mostad\SocialGrant\Delegator\GoogleInputFilterDelegator;
use Mostad\SocialGrant\Factory\Grant\GoogleGrantFactory;
use Mostad\SocialGrant\Grant\GoogleGrant;
use Mostad\User\InputFilter\UserInputFilterInterface;

return [
    'input_filters' => [
        'delegators' => [
            UserInputFilterInterface::class => [
                GoogleInputFilterDelegator::class,
            ]
        ]
    ],

    'zfr_oauth2_server' => [
        'grant_manager' => [
            'factories' => [
                GoogleGrant::class => GoogleGrantFactory::class,
            ],
        ],
        'object_manager' => 'Mostad\ObjectManager',
    ],
];
