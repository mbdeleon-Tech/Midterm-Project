<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to(site_url('customers'));
        }

        return view('auth/login', [
            'title' => 'Staff Login',
            'activePage' => 'login',
            'errors' => session('errors') ?? [],
        ]);
    }

    public function attemptLogin()
    {
        $rules = [
            'username' => 'required|max_length[50]',
            'password' => 'required|max_length[255]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $username = trim((string) $this->request->getPost('username'));
        $user = (new UserModel())->where('username', $username)->first();

        if (! $user || ! password_verify((string) $this->request->getPost('password'), (string) $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'The username or password is incorrect.');
        }

        session()->regenerate(true);
        session()->set([
            'userId' => (int) $user['id'],
            'username' => $user['username'],
            'fullName' => $user['full_name'],
            'isLoggedIn' => true,
        ]);

        $destination = (string) session()->get('redirectAfterLogin');
        session()->remove('redirectAfterLogin');

        if ($destination === '' || ! str_starts_with($destination, site_url())) {
            $destination = site_url('customers');
        }

        return redirect()->to($destination)->with('success', 'Welcome back, ' . $user['full_name'] . '.');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to(site_url('login'))->with('success', 'You have been signed out.');
    }
}
