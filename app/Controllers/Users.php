<?php

namespace App\Controllers;

use App\Libraries\DisplayImage;
use App\Models\UserModel;
use Throwable;

class Users extends BaseController
{
    public function index(): string
    {
        $users = (new UserModel())->select('id, username, full_name, avatar, created_at')->orderBy('id', 'ASC')->findAll();

        return view('users/index', [
            'title' => 'User Accounts',
            'activePage' => 'users',
            'users' => $users,
        ]);
    }

    public function new(): string
    {
        return view('users/form', [
            'title' => 'New User',
            'activePage' => 'users',
            'user' => null,
            'errors' => session('errors') ?? [],
        ]);
    }

    public function create()
    {
        $rules = [
            'username' => 'required|max_length[50]|is_unique[users.username]',
            'full_name' => 'required|max_length[100]',
            'password' => 'required|min_length[8]|max_length[255]',
            'password_confirm' => 'required|matches[password]',
        ];

        $avatar = $this->request->getFile('avatar');
        if ($avatar && $avatar->getError() !== UPLOAD_ERR_NO_FILE) {
            $rules['avatar'] = $this->avatarRule();
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('formInput', $this->request->getPost())->with('errors', $this->validator->getErrors());
        }

        $filename = null;
        if ($avatar && $avatar->isValid() && ! $avatar->hasMoved()) {
            $filename = DisplayImage::store($avatar, 'avatars', 160, 160);
        }

        (new UserModel())->insert([
            'username' => trim((string) $this->request->getPost('username')),
            'full_name' => trim((string) $this->request->getPost('full_name')),
            'password' => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            'avatar' => $filename,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(site_url('users'))->with('success', 'User created successfully.');
    }

    public function edit(int $id): string
    {
        $user = (new UserModel())->select('id, username, full_name, avatar, created_at')->find($id);
        if (! $user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('User not found.');
        }

        return view('users/form', [
            'title' => 'Edit User',
            'activePage' => 'users',
            'user' => $user,
            'usernameValue' => $user['username'],
            'errors' => session('errors') ?? [],
        ]);
    }

    public function update(int $id)
    {
        $model = new UserModel();
        $user = $model->select('id, username, full_name, avatar, created_at')->find($id);
        if (! $user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('User not found.');
        }

        $rules = [
            'username' => "required|max_length[50]|is_unique[users.username,id,{$id}]",
            'full_name' => 'required|max_length[100]',
            'password' => 'permit_empty|min_length[8]|max_length[255]',
        ];
        if ((string) $this->request->getPost('password') !== '') {
            $rules['password_confirm'] = 'required|matches[password]';
        }

        $avatar = $this->request->getFile('avatar');
        if ($avatar && $avatar->getError() !== UPLOAD_ERR_NO_FILE) {
            $rules['avatar'] = $this->avatarRule();
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('formInput', $this->request->getPost())->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => trim((string) $this->request->getPost('username')),
            'full_name' => trim((string) $this->request->getPost('full_name')),
        ];
        if ((string) $this->request->getPost('password') !== '') {
            $data['password'] = password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        if ($avatar && $avatar->isValid() && ! $avatar->hasMoved()) {
            $data['avatar'] = DisplayImage::store($avatar, 'avatars', 160, 160);
        }

        $model->update($id, $data);

        return redirect()->to(site_url('users'))->with('success', 'User updated successfully.');
    }

    public function delete(int $id)
    {
        if ($id === (int) session()->get('userId')) {
            return redirect()->to(site_url('users'))->with('error', 'You cannot delete the account currently signed in.');
        }

        $model = new UserModel();
        if (! $model->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('User not found.');
        }

        try {
            $model->delete($id);
        } catch (Throwable) {
            return redirect()->to(site_url('users'))->with('error', 'This staff account has sales history and cannot be deleted.');
        }

        return redirect()->to(site_url('users'))->with('success', 'Staff account deleted successfully.');
    }

    private function avatarRule(): string
    {
        return 'uploaded[avatar]|max_size[avatar,2048]|is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png,image/webp]';
    }
}
