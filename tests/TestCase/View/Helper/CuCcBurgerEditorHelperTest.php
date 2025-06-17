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
use PHPUnit\Framework\MockObject\MockObject;
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
     * @var MockObject
     */
    public $BcAdminForm;

    public function setUp(): void
    {
        parent::setUp();
        $this->loadPlugins(['CuCcBurgerEditor']);
        $view = new View();
        $this->BcAdminForm = $this->getMockBuilder(\stdClass::class)
            ->addMethods(['editor'])
            ->getMock();
        $this->CuCcBurgerEditorHelper = new CuCcBurgerEditorHelper($view);
        $this->CuCcBurgerEditorHelper->BcAdminForm = $this->BcAdminForm;
    }

     public static function setUpBeforeClass(): void
    {
        BcUtil::includePluginClass('CuCcBurgerEditor');
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
            'name' => 'test',
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

        // previewオプションがない場合
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
        $options = [];
        $expected = '<div>editor</div>';
        $this->BcAdminForm->expects($this->once())
            ->method('editor')
            ->with(
                $this->equalTo('test_field'),
                $this->arrayHasKey('editor')
            )
            ->willReturn($expected);
        $result = $this->CuCcBurgerEditorHelper->control($field, $options);
        $this->assertSame($expected, $result, 'previewオプションがなければeditorの戻り値を返す');
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
