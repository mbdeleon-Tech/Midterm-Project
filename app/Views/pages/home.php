<?= $this->extend('templates/main') ?>
<?= $this->section('content') ?>
<section class="hero shell">
    <div class="hero-copy">
        <p class="eyebrow">Complete store workflow</p>
        <h1>Inventory, customers, staff, and sales in one place.</h1>
        <p class="lede">Northstar POS combines protected management tools with a stock-aware checkout and a clear transaction history.</p>
        <div class="hero-actions">
            <?php if (session()->get('isLoggedIn')): ?>
                <a class="button button-primary" href="<?= site_url('sales/new') ?>">Record a sale</a>
                <a class="button button-secondary" href="<?= site_url('products') ?>">View inventory</a>
            <?php else: ?>
                <a class="button button-primary" href="<?= site_url('login') ?>">Staff login</a>
                <a class="button button-secondary" href="<?= site_url('about') ?>">Explore the system</a>
            <?php endif; ?>
        </div>
    </div>
    <div class="hero-panel" aria-label="System capabilities">
        <div class="panel-heading"><span>POS workspace</span><span class="status"><i></i> Ready</span></div>
        <div class="metric-grid">
            <article><span class="metric-icon">01</span><strong>4</strong><small>Connected database tables</small></article>
            <article><span class="metric-icon">02</span><strong>3</strong><small>Complete CRUD directories</small></article>
            <article><span class="metric-icon">03</span><strong>1</strong><small>Stock-aware sales flow</small></article>
            <article><span class="metric-icon">04</span><strong>100%</strong><small>Protected management pages</small></article>
        </div>
    </div>
</section>
<section class="section shell">
    <div class="section-heading"><div><p class="eyebrow">Midterm project</p><h2>Everything needed for daily point-of-sale work</h2></div><p>Each management page uses validated forms, database models, and authenticated routes. Sales update inventory in the same database transaction.</p></div>
    <div class="feature-grid">
        <a class="feature-card" href="<?= site_url('products') ?>"><span>Inventory</span><h3>Manage products and stock</h3><p>Add prices, quantities, and prepared product images, then update records as inventory changes.</p><b>Open products &rarr;</b></a>
        <a class="feature-card dark" href="<?= site_url('sales/new') ?>"><span>Checkout</span><h3>Record a safe sale</h3><p>Select a product and quantity. The sale is refused when requested stock is not available.</p><b>Start a sale &rarr;</b></a>
        <a class="feature-card" href="<?= site_url('sales') ?>"><span>History</span><h3>Review every transaction</h3><p>See the product, customer, staff member, quantity, total price, and date for each sale.</p><b>View history &rarr;</b></a>
    </div>
</section>
<?= $this->endSection() ?>
