<?= $this->extend('templates/main') ?>
<?= $this->section('content') ?>
<?php $formInput = session('formInput') ?? []; ?>
<section class="page-hero compact shell"><p class="eyebrow">Product management</p><h1><?= $product ? 'Edit product' : 'New product' ?></h1><p>Prices and stock are validated before the inventory record is saved.</p></section>
<section class="form-section shell"><div class="form-card">
<?php if ($errors): ?><div class="notice error"><ul><?php foreach ($errors as $error): ?><li><?= esc($error) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
<form method="post" enctype="multipart/form-data" action="<?= $product ? site_url('products/' . $product['id']) : site_url('products') ?>">
<?= csrf_field() ?>
<div class="field"><label for="name">Product name</label><input id="name" name="name" required maxlength="100" value="<?= esc($formInput['name'] ?? ($product['name'] ?? ''), 'attr') ?>"></div>
<div class="field-grid">
<div class="field"><label for="price">Price</label><input id="price" name="price" type="number" min="0" step="0.01" required value="<?= esc($formInput['price'] ?? ($product['price'] ?? ''), 'attr') ?>"></div>
<div class="field"><label for="stock_quantity">Stock quantity</label><input id="stock_quantity" name="stock_quantity" type="number" min="0" step="1" required value="<?= esc($formInput['stock_quantity'] ?? ($product['stock_quantity'] ?? '0'), 'attr') ?>"></div>
</div>
<div class="field"><label for="image">Product image</label><input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp"><small>Optional. JPG, PNG, or WebP up to 2 MB. A 640 x 480 display copy will be prepared.</small></div>
<div class="form-actions"><button class="button button-primary" type="submit"><?= $product ? 'Save changes' : 'Create product' ?></button><a class="button button-secondary" href="<?= site_url('products') ?>">Cancel</a></div>
</form></div></section>
<?= $this->endSection() ?>
