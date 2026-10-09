<?= $this->extend('templates/main') ?>
<?= $this->section('content') ?>
<?php $formInput = session('formInput') ?? []; ?>
<section class="page-hero compact shell"><p class="eyebrow">Checkout</p><h1>Record a sale</h1><p>Select an in-stock product, choose an optional customer, and enter the quantity sold.</p></section>
<section class="form-section shell"><div class="form-card">
<?php if (session('error')): ?><div class="notice error"><?= esc(session('error')) ?></div><?php endif; ?>
<?php if ($errors): ?><div class="notice error"><ul><?php foreach ($errors as $error): ?><li><?= esc($error) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
<?php if ($products === []): ?><div class="notice error">No products currently have available stock. Update inventory before recording a sale.</div><?php else: ?>
<form method="post" action="<?= site_url('sales') ?>">
<?= csrf_field() ?>
<div class="field"><label for="product_id">Product</label><select id="product_id" name="product_id" required><option value="">Choose a product</option><?php foreach ($products as $product): ?><option value="<?= (int) $product['id'] ?>" <?= (string) ($formInput['product_id'] ?? old('product_id')) === (string) $product['id'] ? 'selected' : '' ?>><?= esc($product['name']) ?> - &#8369;<?= number_format((float) $product['price'], 2) ?> (<?= (int) $product['stock_quantity'] ?> in stock)</option><?php endforeach; ?></select></div>
<div class="field"><label for="customer_id">Customer <span class="optional">Optional</span></label><select id="customer_id" name="customer_id"><option value="">Walk-in customer</option><?php foreach ($customers as $customer): ?><option value="<?= (int) $customer['id'] ?>" <?= (string) ($formInput['customer_id'] ?? old('customer_id')) === (string) $customer['id'] ? 'selected' : '' ?>><?= esc($customer['full_name']) ?></option><?php endforeach; ?></select></div>
<div class="field"><label for="quantity">Quantity</label><input id="quantity" name="quantity" type="number" min="1" step="1" required value="<?= esc($formInput['quantity'] ?? old('quantity') ?? '1', 'attr') ?>"></div>
<div class="form-actions"><button class="button button-primary" type="submit">Complete sale</button><a class="button button-secondary" href="<?= site_url('products') ?>">View inventory</a></div>
</form>
<?php endif; ?>
</div></section>
<?= $this->endSection() ?>
