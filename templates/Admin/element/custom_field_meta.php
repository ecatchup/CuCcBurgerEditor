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
/**
 * カスタムフィールド / フォーム
 * @var \BcCustomContent\View\CustomContentAdminAppView $this
 */
?>



<tr id="RowMetaCuCcBurgerEditor" class="bca-row-meta">
  <th class="col-head bca-form-table__label">
    <?php echo $this->BcAdminForm->label('', __d('baser_core', 'BurgerEditor設定')) ?>
  </th>
  <td class="col-input bca-form-table__input">
    <?php echo $this->BcAdminForm->control('meta.CuCcBurgerEditor.editor_use_draft', ['type' => 'radio', 'options' => [
      true => __d('baser_core', '下書きを利用する'),
      false => __d('baser_core', '下書きを利用しない')
    ]]) ?>
    <?php echo $this->BcAdminForm->error('meta.CuCcBurgerEditor.editor_use_draft') ?>

    <?php echo $this->BcAdminForm->label('meta.BcCcRelated.filter_name', __d('baser_core', '下書きフィールド名')) ?>&nbsp;&nbsp;
    <?php echo $this->BcAdminForm->control('meta.CuCcBurgerEditor.editor_draft_field', ['type' => 'text']) ?>
    <i class="bca-icon--question-circle bca-help"></i>　
    <div class="bca-helptext">
      <?php echo __d('baser_core', '下書きを利用する場合は、別途保存用のフィールドを作成し、そのフィールド名をここに入力します。') ?>
    </div>
    <?php echo $this->BcAdminForm->error('meta.CuCcBurgerEditor.editor_draft_field') ?>
  </td>
</tr>
