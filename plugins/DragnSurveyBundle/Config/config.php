<?php
return array(
    'name'        => 'Drag\'n Survey customizer',
    'description' => 'Customize Mautic for Drag\'n Survey needs (for example localized unsubscribe link / page)',
    'author'      => 'Roman Stec',
    'version'     => '1.0.0',
    'routes'      => [
        'main'   => [],
        'public' => [],
        'api'    => [],
    ],
    'menu'        => [],
    'services' => [
        'integrations' => [
            'mautic.integration.dragnsurvey' => [
                'class' => \MauticPlugin\DragnSurveyBundle\Integration\DragnSurveyIntegration::class,
                'tags' => ['mautic.integration','mautic.basic_integration']
            ]
        ],
        'events' => [
            'mautic.dragnsurvey.emailbundle.subscriber' => [
                'class' => \MauticPlugin\DragnSurveyBundle\EventListener\DragnSurveyEmailBuilderSubscriber::class,
                'arguments' => [
                    'mautic.email.model.email',
                    'translator'
                ]
            ]
        ]
    ]
);