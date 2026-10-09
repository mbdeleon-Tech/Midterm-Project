<?= $this->extend('templates/main') ?>
<?= $this->section('content') ?>
<section class="page-hero compact shell"><p class="eyebrow">Transaction log</p><div class="title-row"><div><h1>Sales History</h1><p>Recorded transactions with product, customer, staff member, quantity, total, and date.</p></div><a class="button button-primary" href="<?= site_url('sales/new') ?>">Record sale</a></div></section>
<section class="table-section shell">
<?php if (session('success')): ?><div class="notice success"><?= esc(session('success')) ?></div><?php endif; ?>
<div class="table-wrap"><table>
<thead><tr><th scope="col">Date</th><th scope="col">Product</th><th scope="col">Customer</th><th scope="col">Staff</th><th scope="col">Quantity</th><th scope="col">Total</th></tr></thead>
<tbody>
<?php foreach ($sales as $sale): ?><tr><td><?= esc(date('M j, Y g:i A', strtotime($sale['created_at']))) ?></td><td><strong><?= esc($sale['product_name']) ?></strong></td><td><?= esc($sale['customer_name'] ?: 'Walk-in customer') ?></td><td><?= esc($sale['staff_name']) ?></td><td><?= (int) $sale['quantity'] ?></td><td><strong>&#8369;<?= number_format((float) $sale['total_price'], 2) ?></strong></td></tr><?php endforeach; ?>
<?php if ($sales === []): ?><tr><td colspan="6">No sales have been recorded yet.</td></tr><?php endif; ?>
</tbody></table></div>
</section>
<?= $this->endSection() ?>
