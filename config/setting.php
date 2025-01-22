<?php

return [
    /**
     * カスタムコンテンツ設定
     *
     * 各フィールドの設定値についての説明は、BcCcText プラグインの setting.php を参考にする
     */
    'BcCustomContent' => [
        'fieldTypes' => [
            /**
             * BcCcBurgerEditor
             *
             * バーガーエディタを表示するフィールドタイプ
             */
            'CuCcBurgerEditor' => [
                'category' => __d('baser_core', 'コンテンツ'),
                'label' => __d('baser_core', 'BurgerEditor'),
                'columnType' => 'text',
                'controlType' => 'text',
//                'preview' => false
            ]
        ]
    ]
];
