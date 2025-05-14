<?php
/**
 * baserCMS :  Based Website Development Project <https://basercms.net>
 * Copyright (c) NPO baser foundation <https://baserfoundation.org/>
 *
 * @copyright     Copyright (c) NPO baser foundation
 * @link          https://basercms.net baserCMS Project
 * @since         5.0.0
 * @license       https://basercms.net/license/index.html MIT License
 */

namespace CuCcBurgerEditor\Event;

use BaserCore\Event\BcControllerEventListener;
use Cake\Core\Configure;
use Cake\Event\EventInterface;
use Cake\ORM\TableRegistry;

class CuCcBurgerEditorControllerEventListener extends BcControllerEventListener
{

    /**
     * Events
     * @var string
     */
    public $events = [
        'initialize'
    ];

    /**
     * initialize
     *
     * @param \Cake\Event\EventInterface $event
     * @return void
     */
    public function initialize(EventInterface $event)
    {
        $customFieldsTable = TableRegistry::getTableLocator()->get('BcCustomContent.CustomFields');
        $customFields = $customFieldsTable->find()->where([
            'type' => 'CuCcBurgerEditor',
            'status' => true,
        ])->all();
        $targetColumns = Configure::read('Bge.targetColumns');
        foreach($customFields as $customField) {
            if(!empty($customField->meta['CuCcBurgerEditor']['editor_use_draft'])) {
                $targetColumns[] = $customField->name . '_draft';
            }
        }
        Configure::write('Bge.targetColumns', $targetColumns);
    }

}
