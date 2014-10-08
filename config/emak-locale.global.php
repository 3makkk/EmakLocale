<?php

return array(
    'router' => array(
        'routes' => array(
            'language'  => array(
                'type' => 'Segment',
                'may_terminate' => true,
                'options' => array(
                    'route' => '/:lang',
                    'defaults' => array(
                        'controller' => 'Your\MainController\Index',
                        'action' => 'index',
                        'lang' => 'de_DE'
                    ),
                    'constraints' => array(
                        'lang' => '(de_DE|en_US)?'
                    ),
                ),
                'child_routes' => array()
            )
        )
    )
);
