<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * Classes that are restricted to use directly.
 * A <replacement> will be suggested to be used instead.
 * Use <whitelist> to specify files and directories that are allowed to use restricted classes.
 *
 * Format: array(<class_name>, <replacement>[, array(<whitelist>)]])
 */
return [
    'Zend_Db_Select' => [
        'replacement' => '\Magento\Framework\DB\Select',
        'exclude' => [
            [
                'type' => 'library',
                'name' => 'magento/framework',
                'path' => 'DB/Select.php'
            ],
            [
                'type' => 'library',
                'name' => 'magento/framework',
                'path' => 'DB/Adapter/Pdo/Mysql.php'
            ],
            [
                'type' => 'library',
                'name' => 'magento/framework',
                'path' => 'Model/ResourceModel/Iterator.php'
            ],
        ]
    ],
    'Zend_Db_Adapter_Pdo_Mysql' => [
        'replacement' => '\Magento\Framework\DB\Adapter\Pdo\Mysql',
        'exclude' => [
            [
                'type' => 'library',
                'name' => 'magento/framework',
                'path' => 'DB/Adapter/Pdo/Mysql.php'
            ],
        ]
    ],
    'Magento\Framework\Serialize\Serializer\Serialize' => [
        'replacement' => 'Magento\Framework\Serialize\SerializerInterface',
        'exclude' => [
            [
                'type' => 'library',
                'name' => 'magento/framework',
                'path' => 'App/ObjectManager/ConfigLoader/Compiled.php'
            ],
            [
                'type' => 'library',
                'name' => 'magento/framework',
                'path' => 'App/Config/ScopePool.php'],
            [
                'type' => 'library',
                'name' => 'magento/framework',
                'path' => 'App/ObjectManager/ConfigCache.php'
            ],
            [
                'type' => 'library',
                'name' => 'magento/framework',
                'path' => 'App/ObjectManager/ConfigLoader.php'
            ],
            [
                'type' => 'library',
                'name' => 'magento/framework',
                'path' => 'DB/Adapter/Pdo/Mysql.php'
            ],
            [
                'type' => 'library',
                'name' => 'magento/framework',
                'path' => 'DB/DataConverter/SerializedToJson.php'
            ],
            [
                'type' => 'library',
                'name' => 'magento/framework',
                'path' => 'DB/Test/Unit/DataConverter/SerializedToJsonTest.php'
            ],
            [
                'type' => 'library',
                'name' => 'magento/framework',
                'path' => 'ObjectManager/Config/Compiled.php'
            ],
            [
                'type' => 'library',
                'name' => 'magento/framework',
                'path' => 'Interception/Config/Config.php'
            ],
            [
                'type' => 'library',
                'name' => 'magento/framework',
                'path' => 'Interception/PluginList/PluginList.php'
            ],
            [
                'type' => 'library',
                'name' => 'magento/framework',
                'path' => 'App/Router/ActionList.php'
            ],
            [
                'type' => 'library',
                'name' => 'magento/framework',
                'path' => 'Serialize/Test/Unit/Serializer/SerializeTest.php'
            ],
            [
                'type' => 'setup',
                'path' => 'src/Magento/Setup/Module/Di/Compiler/Config/Writer/Filesystem.php'
            ],
            [
                'type' => 'module',
                'name' => 'Magento_Sales',
                'path' => 'Setup/SerializedDataConverter.php'
            ],
            [
                'type' => 'module',
                'name' => 'Magento_Sales',
                'path' => 'Test/Unit/Setup/SerializedDataConverterTest.php'
            ],
        ]
    ]
];
