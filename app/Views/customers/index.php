<?= $this->extend('templates/main') ?>

<?= $this->section('content') ?>
<section class="page-hero compact shell">
    <p class="eyebrow">Account directory</p>
    <div class="title-row"><div><h1>Customer Accounts</h1><p>Contact details for <?= count($customers) ?> customers retrieved from the MySQL database.</p></div><a class="button button-primary" href="<?= site_url('customers/new') ?>">New customer</a></div>
</section>
<section class="table-section shell">
    <?php if (session('success')): ?><div class="notice success"><?= esc(session('success')) ?></div><?php endif; ?>
    <?php if (session('error')): ?><div class="notice error"><?= esc(session('error')) ?></div><?php endif; ?>
    <div class="table-wrap"><table>
        <thead><tr><th scope="col">Customer</th><th scope="col">Email address</th><th scope="col">Phone number</th><th scope="col">Action</th></tr></thead>
        <tbody>
        <?php foreach ($customers as $customer): ?>
            <tr>
                <td><span class="avatar"><?= esc(strtoupper(substr($customer['full_name'], 0, 1))) ?></span><strong><?= esc($customer['full_name']) ?></strong></td>
                <td><a href="mailto:<?= esc($customer['email']) ?>"><?= esc($customer['email']) ?></a></td>
                <td><?= esc($customer['phone']) ?></td>
                <td><div class="row-actions"><a class="text-link" href="<?= site_url('customers/' . $customer['id'] . '/edit') ?>">Edit</a><form method="post" action="<?= site_url('customers/' . $customer['id'] . '/delete') ?>" onsubmit="return confirm('Delete this customer?')"><?= csrf_field() ?><button class="danger-link" type="submit">Delete</button></form></div></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table></div>
</section>
<?= $this->endSection() ?>
