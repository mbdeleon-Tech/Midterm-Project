<?= $this->extend('templates/main') ?>
<?= $this->section('content') ?>
<?php $formInput = session('formInput') ?? []; ?>
<section class="page-hero compact shell"><p class="eyebrow">Customer form</p><h1><?= $customer ? 'Edit customer' : 'New customer' ?></h1><p>Required details are checked before the record is saved.</p></section>
<section class="form-section shell"><div class="form-card">
<?php if ($errors): ?><div class="notice error"><ul><?php foreach ($errors as $error): ?><li><?= esc($error) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
<form method="post" action="<?= $customer ? site_url('customers/' . $customer['id']) : site_url('customers') ?>">
<?= csrf_field() ?>
<div class="field"><label for="full_name">Full name</label><input id="full_name" name="full_name" required maxlength="100" value="<?= esc($formInput['full_name'] ?? ($customer['full_name'] ?? ''), 'attr') ?>"></div>
<div class="field"><label for="email">Email address</label><input id="email" name="email" type="email" required maxlength="100" value="<?= esc($formInput['email'] ?? ($customer['email'] ?? ''), 'attr') ?>"></div>
<div class="field"><label for="phone">Phone number</label><input id="phone" name="phone" maxlength="20" value="<?= esc($formInput['phone'] ?? ($customer['phone'] ?? ''), 'attr') ?>"></div>
<div class="form-actions"><button class="button button-primary" type="submit"><?= $customer ? 'Save changes' : 'Create customer' ?></button><a class="button button-secondary" href="<?= site_url('customers') ?>">Cancel</a></div>
</form></div></section>
<?= $this->endSection() ?>
