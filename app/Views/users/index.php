<?= $this->extend('templates/main') ?>

<?= $this->section('content') ?>
<section class="page-hero compact shell">
    <p class="eyebrow">Team directory</p>
    <div class="title-row"><div><h1>Staff Accounts</h1><p>Secure staff accounts with display-ready profile images.</p></div><a class="button button-primary" href="<?= site_url('users/new') ?>">New staff account</a></div>
</section>
<section class="table-section shell">
    <?php if (session('success')): ?><div class="notice success"><?= esc(session('success')) ?></div><?php endif; ?>
    <?php if (session('error')): ?><div class="notice error"><?= esc(session('error')) ?></div><?php endif; ?>
    <div class="table-wrap"><table>
        <thead><tr><th scope="col">User</th><th scope="col">Full name</th><th scope="col">Created</th><th scope="col">Action</th></tr></thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><img class="avatar-image" src="<?= base_url($user['avatar'] ? 'uploads/avatars/' . $user['avatar'] : 'uploads/placeholder.svg') ?>" alt=""><code class="username"><?= esc($user['username']) ?></code></td>
                <td><strong><?= esc($user['full_name']) ?></strong></td>
                <td><span class="role-badge"><?= esc(date('M j, Y', strtotime($user['created_at']))) ?></span></td>
                <td><div class="row-actions"><a class="text-link" href="<?= site_url('users/' . $user['id'] . '/edit') ?>">Edit</a><?php if ((int) $user['id'] !== (int) session()->get('userId')): ?><form method="post" action="<?= site_url('users/' . $user['id'] . '/delete') ?>" onsubmit="return confirm('Delete this staff account?')"><?= csrf_field() ?><button class="danger-link" type="submit">Delete</button></form><?php endif; ?></div></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table></div>
</section>
<?= $this->endSection() ?>
