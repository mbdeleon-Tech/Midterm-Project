<?php

namespace App\Controllers;

use App\Libraries\DisplayImage;
use App\Models\ProductModel;
use Throwable;

class Products extends BaseController
{
    private array $rules = [
        'name' => 'required|max_length[100]',
        'price' => 'required|decimal|greater_than_equal_to[0]',
        'stock_quantity' => 'required|integer|greater_than_equal_to[0]',
    ];

    public function index(): string
    {
        return view('products/index', [
            'title' => 'Products',
            'activePage' => 'products',
            'products' => (new ProductModel())->orderBy('name', 'ASC')->findAll(),
        ]);
    }

    public function new(): string
    {
        return view('products/form', [
            'title' => 'New Product',
            'activePage' => 'products',
            'product' => null,
            'errors' => session('errors') ?? [],
        ]);
    }

    public function create()
    {
        $rules = $this->rules;
        $image = $this->request->getFile('image');
        if ($image && $image->getError() !== UPLOAD_ERR_NO_FILE) {
            $rules['image'] = $this->imageRule();
        }

        if (! $this->validate($rules)) {
            return $this->invalidForm();
        }

        $filename = null;
        if ($image && $image->isValid() && ! $image->hasMoved()) {
            $filename = DisplayImage::store($image, 'products', 640, 480);
        }

        (new ProductModel())->insert([
            'name' => trim((string) $this->request->getPost('name')),
            'price' => number_format((float) $this->request->getPost('price'), 2, '.', ''),
            'stock_quantity' => (int) $this->request->getPost('stock_quantity'),
            'image' => $filename,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(site_url('products'))->with('success', 'Product created successfully.');
    }

    public function edit(int $id): string
    {
        $product = (new ProductModel())->find($id);
        if (! $product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Product not found.');
        }

        return view('products/form', [
            'title' => 'Edit Product',
            'activePage' => 'products',
            'product' => $product,
            'errors' => session('errors') ?? [],
        ]);
    }

    public function update(int $id)
    {
        $model = new ProductModel();
        $product = $model->find($id);
        if (! $product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Product not found.');
        }

        $rules = $this->rules;
        $image = $this->request->getFile('image');
        if ($image && $image->getError() !== UPLOAD_ERR_NO_FILE) {
            $rules['image'] = $this->imageRule();
        }

        if (! $this->validate($rules)) {
            return $this->invalidForm();
        }

        $data = [
            'name' => trim((string) $this->request->getPost('name')),
            'price' => number_format((float) $this->request->getPost('price'), 2, '.', ''),
            'stock_quantity' => (int) $this->request->getPost('stock_quantity'),
        ];

        if ($image && $image->isValid() && ! $image->hasMoved()) {
            $data['image'] = DisplayImage::store($image, 'products', 640, 480);
        }

        $model->update($id, $data);

        return redirect()->to(site_url('products'))->with('success', 'Product updated successfully.');
    }

    public function delete(int $id)
    {
        $model = new ProductModel();
        if (! $model->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Product not found.');
        }

        try {
            $model->delete($id);
        } catch (Throwable) {
            return redirect()->to(site_url('products'))->with('error', 'This product has sales history and cannot be deleted.');
        }

        return redirect()->to(site_url('products'))->with('success', 'Product deleted successfully.');
    }

    private function imageRule(): string
    {
        return 'uploaded[image]|max_size[image,2048]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]';
    }

    private function invalidForm()
    {
        return redirect()->back()->withInput()->with('formInput', $this->request->getPost())->with('errors', $this->validator->getErrors());
    }
}
