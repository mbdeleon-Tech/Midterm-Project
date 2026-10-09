<?= $this->extend('templates/main') ?>
<?= $this->section('content') ?>
<section class="page-hero compact shell">
    <p class="eyebrow">Protected staff access</p>
    <h1>Sign in to Northstar POS</h1>
    <p>Inventory, customer, staff, and sales pages are available only to verified staff members.</p>
</section>

<section class="form-section shell">
    <div class="form-card login-card">
        <?php if (session('success')): ?>
            <div class="notice success"><?= esc(session('success')) ?></div>
        <?php endif; ?>
        <?php if (session('error')): ?>
            <div class="notice error"><?= esc(session('error')) ?></div>
        <?php endif; ?>
        <?php if (! empty($errors)): ?>
            <div class="notice error">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= site_url('login') ?>">
            <?= csrf_field() ?>
            <div class="field">
                <label for="username">Username</label>
                <input id="username" name="username" type="text" value="<?= esc(old('username')) ?>" maxlength="50" autocomplete="username" required>
            </div>
            <div class="field">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" maxlength="255" autocomplete="current-password" required>
            </div>
            <button class="button button-primary" type="submit">Sign in</button>
        </form>

        <div class="demo-login">
            <strong>Demo staff account</strong>
            <span>Username: <code>admin.marc</code></span>
            <span>Password: <code>Northstar123!</code></span>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
