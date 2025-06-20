<?php
/**
 * Copyright (c) Catchup, Inc. <https://catchup.co.jp>
 *
 * @copyright        Copyright (c) Catchup, Inc.
 * @link             https://catchup.co.jp
 * @license          MIT LICENSE
 */

namespace CuCcBurgerEditor\Test\TestCase\View\Helper;

use BaserCore\TestSuite\BcTestCase;
use BaserCore\Utility\BcUtil;
use Cake\View\View;
use CuCcBurgerEditor\View\Helper\CuCcBurgerEditorHelper;

/**
 * CuCcBurgerEditorHelper Test Case
 * @property CuCcBurgerEditorHelper $CuCcBurgerEditorHelper
 */
class CuCcBurgerEditorHelperTest extends BcTestCase
{

    /**
     * @var CuCcBurgerEditorHelper
     */
    public $CuCcBurgerEditorHelper;

    /**
     * setUp method
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->loadPlugins(['CuCcBurgerEditor', 'BurgerEditor']);
        $view = new View($this->getRequest());
        $this->CuCcBurgerEditorHelper = new CuCcBurgerEditorHelper($view);
    }

    /**
     * setUpBeforeClass method
     * @return void
     */
    public static function setUpBeforeClass(): void
    {
        BcUtil::includePluginClass(['CuCcBurgerEditor', 'BurgerEditor']);
    }

    /**
     * control()のテスト
     *
     * - previewオプションがtrueなら空文字を返す
     * - previewオプションがなければBcAdminForm->editorが呼ばれ、その戻り値を返す
     */
    public function test_control()
    {
        // previewオプションがtrueの場合
        $field = (object)[
            'name' => 'test_field',
            'custom_field' => (object)[
                'meta' => [
                    'CuCcBurgerEditor' => [
                        'editor_use_draft' => true
                    ]
                ]
            ]
        ];
        $result = $this->CuCcBurgerEditorHelper->control($field, ['preview' => true]);
        $this->assertSame('', $result, 'previewオプションがtrueなら空文字を返す');

        // 下書きがある場合
        $options = [];
        ob_start();
        $result = $this->CuCcBurgerEditorHelper->control($field, $options);
        ob_end_clean();
        $this->assertStringContainsString('<div class="draft-btn clearfix">', $result, 'previewオプションがなければeditorの戻り値を返す');

        // 下書きがない場合
        $field->custom_field->meta['CuCcBurgerEditor']['editor_use_draft'] = false;
        ob_start();
        $result = $this->CuCcBurgerEditorHelper->control($field, $options);
        ob_end_clean();
        $this->assertStringNotContainsString('<div class="draft-btn clearfix" style="display:none;">', $result);
    }

    /**
     * get()のテスト
     *
     * - fieldValueをそのまま返す
     */
    public function test_get()
    {
        $fieldValue = '<p>テスト本文</p>';
        $link = $this->createMock(\BcCustomContent\Model\Entity\CustomLink::class);
        $result = $this->CuCcBurgerEditorHelper->get($fieldValue, $link);
        $this->assertSame($fieldValue, $result, 'fieldValueをそのまま返す');
    }

}
