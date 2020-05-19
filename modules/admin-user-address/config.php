<?php

return [
    '__name' => 'admin-user-address',
    '__version' => '0.0.1',
    '__git' => 'git@github.com:getmim/admin-user-address.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'http://iqbalfn.com/'
    ],
    '__files' => [
        'modules/admin-user-address' => ['install','update','remove'],
        'theme/admin/user/address.phtml' => ['install','update','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'admin-user' => NULL
            ],
            [
                'user-address' => NULL
            ]
        ],
        'optional' => []
    ],
    'autoload' => [
        'classes' => [
            'AdminUserAddress\\Controller' => [
                'type' => 'file',
                'base' => 'modules/admin-user-address/controller'
            ]
        ],
        'files' => []
    ],
    'routes' => [
        'admin' => [
            'adminUserAddressEdit' => [
                'path' => [
                    'value' => '/user/(:id)/address',
                    'params' => [
                        'id' => 'number'
                    ]
                ],
                'method' => 'GET|POST',
                'handler' => 'AdminUserAddress\\Controller\\Address::edit'
            ]
        ]
    ],
    'adminUser' => [
        'menu' => [
            'address' => [
                'label' => 'Address',
                'perm' => 'manage_user_address',
                'route' => ['adminUserAddressEdit',['id' => '$id']],
                'index' => 2500
            ]
        ]
    ],
    'libForm' => [
        'forms' => [
            'admin.user.address' => [
                'country' => [
                    'label' => 'Country',
                    'type' => 'select',
                    'sl-filter' => [
                        'route' => 'adminObjectFilter',
                        'params' => [],
                        'query' => ['type' => 'addr-country']
                    ],
                    'rules' => [
                        'exists' => [
                            'model' => 'LibAddress\\Model\\AddrCountry',
                            'field' => 'id'
                        ]
                    ]
                ],
                'state' => [
                    'label' => 'State',
                    'type' => 'select',
                    'sl-filter' => [
                        'route' => 'adminObjectFilter',
                        'params' => [],
                        'query' => [
                            'type' => 'addr-state',
                            'parent' => '#country'
                        ]
                    ],
                    'rules' => [
                        'exists' => [
                            'model' => 'LibAddress\\Model\\AddrState',
                            'field' => 'id'
                        ]
                    ]
                ],
                'city' => [
                    'label' => 'City',
                    'type' => 'select',
                    'sl-filter' => [
                        'route' => 'adminObjectFilter',
                        'params' => [],
                        'query' => [
                            'type' => 'addr-city',
                            'parent' => '#state'
                        ]
                    ],
                    'rules' => [
                        'exists' => [
                            'model' => 'LibAddress\\Model\\AddrCity',
                            'field' => 'id'
                        ]
                    ]
                ],
                'district' => [
                    'label' => 'District',
                    'type' => 'select',
                    'sl-filter' => [
                        'route' => 'adminObjectFilter',
                        'params' => [],
                        'query' => [
                            'type' => 'addr-district',
                            'parent' => '#city'
                        ]
                    ],
                    'rules' => [
                        'exists' => [
                            'model' => 'LibAddress\\Model\\AddrDistrict',
                            'field' => 'id'
                        ]
                    ]
                ],
                'village' => [
                    'label' => 'Village',
                    'type' => 'select',
                    'sl-filter' => [
                        'route' => 'adminObjectFilter',
                        'params' => [],
                        'query' => [
                            'type' => 'addr-village',
                            'parent' => '#district'
                        ]
                    ],
                    'rules' => [
                        'exists' => [
                            'model' => 'LibAddress\\Model\\AddrVillage',
                            'field' => 'id'
                        ]
                    ]
                ],
                'zipcode' => [
                    'label' => 'Zip Code',
                    'type' => 'select',
                    'sl-filter' => [
                        'route' => 'adminObjectFilter',
                        'params' => [],
                        'query' => [
                            'type' => 'addr-zip',
                            'parent' => '#village'
                        ]
                    ],
                    'rules' => [
                        'exists' => [
                            'model' => 'LibAddress\\Model\\AddrZipcode',
                            'field' => 'id'
                        ]
                    ]
                ],
                'street' => [
                    'type' => 'textarea',
                    'label' => 'Street',
                    'rules' => []
                ]
            ]
        ]
    ]
];