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

    public function testControlReturnsEmptyStringIfPreviewOptionIsSet()
    {
        $field = (object)['name' => 'test', 'custom_field' => (object)['meta' => ['CuCcBurgerEditor' => ['editor_use_draft' => true]]]];
        $result = $this->CuCcBurgerEditorHelper->control($field, ['preview' => true]);
        $this->assertSame('', $result);
    }

    public function testControlCallsEditorWithCorrectArguments()
    {
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
        $this->assertSame($expected, $result);
    }
}
