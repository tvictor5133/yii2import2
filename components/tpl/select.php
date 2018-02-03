<option value="<?= $category['id'] ?>"
    <?php
    if (isset($this->model->product_id))
        echo ($category['id'] == $this->model->product_id ? ' selected' : '');
    if (isset($this->model->param_id))
        echo ($category['id'] == $this->model->param_id ? ' selected' : '');
    if (isset($this->model->parent_id))
        echo ($category['id'] == $this->model->parent_id ? ' selected' : '');
    if (isset($this->model->category_id))
        echo ($category['id'] == $this->model->category_id ? ' selected' : '');
     ?>
    ><?= $tab . $category['name'] ?></option>
<?php if (isset($category['childs'])): ?>
    <ul>
        <?= $this->getMenuHtml($category['childs'], $tab . '-') ?>
    </ul>
<?php endif; ?>