<?php

array(
    'builder'  => object(ControlPanelBuilder),
    'sections' => array(
        array(
            'buttons'    => array(
                'new_discount' => array(
                    'data-toggle' => 'modal',
                    'data-target' => '#modal',
                    'href'        => 'admin/discounts/choose'
                )
            ),
            'sections'   => array(
                'filters'    => array(
                    'href'    => 'admin/discounts/filters/{request.route.parameters.discount}',
                    'buttons' => array(
                        'add_filter' => array(
                            'data-toggle' => 'modal',
                            'data-target' => '#modal',
                            'href'        => 'admin/discounts/filters/{request.route.parameters.discount}/choose'
                        )
                    )
                ),
                'conditions' => array(
                    'href'    => 'admin/discounts/conditions/{request.route.parameters.discount}',
                    'buttons' => array(
                        'add_condition' => array(
                            'data-toggle' => 'modal',
                            'data-target' => '#modal',
                            'href'        => 'admin/discounts/conditions/{request.route.parameters.discount}/choose'
                        )
                    )
                )
            ),
            'slug'       => 'discounts',
            'attributes' => array('href' => 'https://motionraceworks.dfw01.cld.tstr.us/admin/discounts')
        ),
        array(
            'href'    => 'admin/discounts/filters/{request.route.parameters.discount}',
            'buttons' => array(
                'add_filter' => array(
                    'data-toggle' => 'modal',
                    'data-target' => '#modal',
                    'href'        => 'admin/discounts/filters/{request.route.parameters.discount}/choose'
                )
            ),
            'parent'  => 'discounts'
        ),
        array(
            'href'    => 'admin/discounts/conditions/{request.route.parameters.discount}',
            'buttons' => array(
                'add_condition' => array(
                    'data-toggle' => 'modal',
                    'data-target' => '#modal',
                    'href'        => 'admin/discounts/conditions/{request.route.parameters.discount}/choose'
                )
            ),
            'parent'  => 'discounts'
        )
    ),
    'index'    => '1',
    'section'  => array(
        'href'    => 'admin/discounts/filters/{request.route.parameters.discount}',
        'buttons' => array(
            'add_filter' => array(
                'data-toggle' => 'modal',
                'data-target' => '#modal',
                'href'        => 'admin/discounts/filters/{request.route.parameters.discount}/choose'
            )
        ),
        'parent'  => 'discounts'
    ),
    'module'   => object(DiscountsModule),
    'href'     => 'https://motionraceworks.dfw01.cld.tstr.us/admin/discounts'
));