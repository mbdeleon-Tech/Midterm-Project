<?= $this->extend('templates/main') ?>
<?= $this->section('content') ?>
<?php $formInput = session('formInput') ?? []; ?>
<section class="page-hero compact shell">
    <p class="eyebrow">User management</p>
    <h1><?= esc($title) ?></h1>
    <p><?= $user ? 'Update account details or set a new password.' : 'Create a staff account with a secure password.' ?></p>
</section>
<section class="form-section shell">
    <div class="form-card">
        <?php if (! empty($errors)): ?>
            <div class="notice error"><ul><?php foreach ($errors as $error): ?><li><?= esc($error) ?></li><?php endforeach; ?></ul></div>
        <?php endif; ?>
        <form method="post" enctype="multipart/form-data" action="<?= $user ? site_url('users/' . $user['id']) : site_url('users') ?>">
            <?= csrf_field() ?>
            <div class="field"><label for="username">Username</label><input id="username" name="username" required maxlength="50" autocomplete="username" value="<?= esc($formInput['username'] ?? ($usernameValue ?? ($user['username'] ?? '')), 'attr') ?>"></div>
            <div class="field"><label for="full_name">Full name</label><input id="full_name" name="full_name" required maxlength="100" autocomplete="name" value="<?= esc($formInput['full_name'] ?? ($user['full_name'] ?? ''), 'attr') ?>"></div>
            <div class="field">
                <label for="password"><?= $user ? 'New password' : 'Password' ?></label>
                <input id="password" name="password" type="password" minlength="8" maxlength="255" autocomplete="new-password" <?= $user ? '' : 'required' ?>>
                <small><?= $user ? 'Leave blank to keep the current password.' : 'Use at least 8 characters.' ?></small>
            </div>
            <div class="field">
                <label for="password_confirm">Confirm password</label>
                <input id="password_confirm" name="password_confirm" type="password" minlength="8" maxlength="255" autocomplete="new-password" <?= $user ? '' : 'required' ?>>
            </div>
            <div class="field"><label for="avatar">Profile picture</label><input id="avatar" name="avatar" type="file" accept="image/jpeg,image/png,image/webp"><small>Optional. JPG, PNG, or WebP up to 2 MB. A square 160 x 160 display copy will be prepared.</small></div>
            <div class="form-actions"><button class="button button-primary" type="submit"><?= $user ? 'Save changes' : 'Create user' ?></button><a class="button button-secondary" href="<?= site_url('users') ?>">Cancel</a></div>
        </form>
    </div>
</section>
<?= $this->endSection() ?>
