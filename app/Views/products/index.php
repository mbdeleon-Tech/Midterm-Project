<?= $this->extend('templates/main') ?>
<?= $this->section('content') ?>
<section class="page-hero compact shell">
    <p class="eyebrow">Inventory management</p>
    <div class="title-row"><div><h1>Products</h1><p>Current prices, stock levels, and display-ready product images.</p></div><a class="button button-primary" href="<?= site_url('products/new') ?>">New product</a></div>
</section>
<section class="table-section shell">
    <?php if (session('success')): ?><div class="notice success"><?= esc(session('success')) ?></div><?php endif; ?>
    <?php if (session('error')): ?><div class="notice error"><?= esc(session('error')) ?></div><?php endif; ?>
    <div class="table-wrap"><table>
        <thead><tr><th scope="col">Product</th><th scope="col">Price</th><th scope="col">Available stock</th><th scope="col">Created</th><th scope="col">Actions</th></tr></thead>
        <tbody>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><img class="product-thumb" src="<?= base_url($product['image'] ? 'uploads/products/' . $product['image'] : 'uploads/product-placeholder.svg') ?>" alt=""><strong><?= esc($product['name']) ?></strong></td>
                <td><strong>&#8369;<?= number_format((float) $product['price'], 2) ?></strong></td>
                <td><span class="stock-badge <?= (int) $product['stock_quantity'] === 0 ? 'empty' : '' ?>"><?= (int) $product['stock_quantity'] ?> units</span></td>
                <td><?= esc(date('M j, Y', strtotime($product['created_at']))) ?></td>
                <td><div class="row-actions"><a class="text-link" href="<?= site_url('products/' . $product['id'] . '/edit') ?>">Edit</a><form method="post" action="<?= site_url('products/' . $product['id'] . '/delete') ?>" onsubmit="return confirm('Delete this product?')"><?= csrf_field() ?><button class="danger-link" type="submit">Delete</button></form></div></td>
            </tr>
        <?php endforeach; ?>
        <?php if ($products === []): ?><tr><td colspan="5">No products have been added yet.</td></tr><?php endif; ?>
        </tbody>
    </table></div>
</section>
<?= $this->endSection() ?>
