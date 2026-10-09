<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class Customers extends BaseController
{
    private array $rules = [
        'full_name' => 'required|max_length[100]',
        'email' => 'required|valid_email|max_length[100]',
        'phone' => 'permit_empty|max_length[20]',
    ];

    public function index(): string
    {
        $customers = (new CustomerModel())->orderBy('id', 'ASC')->findAll();

        return view('customers/index', [
            'title' => 'Customer Accounts',
            'activePage' => 'customers',
            'customers' => $customers,
        ]);
    }

    public function new(): string
    {
        return view('customers/form', ['title' => 'New Customer', 'activePage' => 'customers', 'customer' => null, 'errors' => session('errors') ?? []]);
    }

    public function create()
    {
        if (! $this->validate($this->rules)) {
            return redirect()->back()->withInput()->with('formInput', $this->request->getPost())->with('errors', $this->validator->getErrors());
        }

        (new CustomerModel())->insert([
            'full_name' => trim((string) $this->request->getPost('full_name')),
            'email' => trim((string) $this->request->getPost('email')),
            'phone' => trim((string) $this->request->getPost('phone')),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(site_url('customers'))->with('success', 'Customer created successfully.');
    }

    public function edit(int $id): string
    {
        $customer = (new CustomerModel())->find($id);
        if (! $customer) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Customer not found.');
        }
        return view('customers/form', ['title' => 'Edit Customer', 'activePage' => 'customers', 'customer' => $customer, 'errors' => session('errors') ?? []]);
    }

    public function update(int $id)
    {
        $model = new CustomerModel();
        if (! $model->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Customer not found.');
        }
        if (! $this->validate($this->rules)) {
            return redirect()->back()->withInput()->with('formInput', $this->request->getPost())->with('errors', $this->validator->getErrors());
        }
        $model->update($id, [
            'full_name' => trim((string) $this->request->getPost('full_name')),
            'email' => trim((string) $this->request->getPost('email')),
            'phone' => trim((string) $this->request->getPost('phone')),
        ]);
        return redirect()->to(site_url('customers'))->with('success', 'Customer updated successfully.');
    }

    public function delete(int $id)
    {
        $model = new CustomerModel();
        if (! $model->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Customer not found.');
        }

        $model->delete($id);

        return redirect()->to(site_url('customers'))->with('success', 'Customer deleted successfully.');
    }
}
