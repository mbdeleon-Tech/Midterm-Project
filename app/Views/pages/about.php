<?= $this->extend('templates/main') ?>
<?= $this->section('content') ?>
<section class="page-hero shell"><p class="eyebrow">About the project</p><h1>A complete CodeIgniter point-of-sale system.</h1><p>Northstar POS connects products, customers, staff, and sales through a relational MySQL database and a protected MVC workflow.</p></section>
<section class="section shell about-grid">
    <div><p class="eyebrow">Transaction safety</p><h2>Stock and sales stay in sync</h2><p class="body-copy">A completed sale records the transaction and reduces stock together. If the requested quantity is greater than the current stock, the transaction is rejected and no inventory is changed.</p></div>
    <ol class="process-list">
        <li><span>01</span><div><h3>Authenticate</h3><p>A route filter allows only signed-in staff members to open management pages.</p></div></li>
        <li><span>02</span><div><h3>Validate</h3><p>CodeIgniter validates form fields and restricts uploaded images before saving.</p></div></li>
        <li><span>03</span><div><h3>Record</h3><p>The sale total is calculated from the stored product price and the stock update is committed with the transaction.</p></div></li>
    </ol>
</section>
<section class="section shell values-grid"><article><strong>Framework</strong><p>CodeIgniter 4</p></article><article><strong>Database</strong><p>MySQL</p></article><article><strong>Security</strong><p>Sessions and hashed passwords</p></article><article><strong>Images</strong><p>Validated and display-ready</p></article></section>
<?= $this->endSection() ?>
