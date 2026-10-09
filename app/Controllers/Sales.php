<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\ProductModel;
use App\Models\SaleModel;

class Sales extends BaseController
{
    public function index(): string
    {
        return view('sales/index', [
            'title' => 'Sales History',
            'activePage' => 'sales',
            'sales' => (new SaleModel())->history(),
        ]);
    }

    public function new(): string
    {
        return view('sales/form', [
            'title' => 'Record Sale',
            'activePage' => 'record-sale',
            'products' => (new ProductModel())->where('stock_quantity >', 0)->orderBy('name', 'ASC')->findAll(),
            'customers' => (new CustomerModel())->orderBy('full_name', 'ASC')->findAll(),
            'errors' => session('errors') ?? [],
        ]);
    }

    public function create()
    {
        $rules = [
            'product_id' => 'required|integer|greater_than[0]',
            'customer_id' => 'permit_empty|integer|greater_than[0]',
            'quantity' => 'required|integer|greater_than[0]',
        ];

        if (! $this->validate($rules)) {
            return $this->invalidForm();
        }

        $productId = (int) $this->request->getPost('product_id');
        $customerValue = trim((string) $this->request->getPost('customer_id'));
        $customerId = $customerValue === '' ? null : (int) $customerValue;
        $quantity = (int) $this->request->getPost('quantity');
        $userId = (int) session()->get('userId');

        if ($customerId !== null && ! (new CustomerModel())->find($customerId)) {
            return redirect()->back()->withInput()->with('error', 'The selected customer no longer exists.');
        }

        $database = db_connect();

        $database->transBegin();

        $product = $database->table('products')->where('id', $productId)->get()->getRowArray();
        if (! $product) {
            $database->transRollback();
            return redirect()->back()->withInput()->with('error', 'The selected product no longer exists.');
        }

        $updated = $database->table('products')
            ->set('stock_quantity', 'stock_quantity - ' . $quantity, false)
            ->where('id', $productId)
            ->where('stock_quantity >=', $quantity)
            ->update();

        if (! $updated || $database->affectedRows() !== 1) {
            $database->transRollback();
            return redirect()->back()->withInput()->with('error', 'Sale rejected: only ' . $product['stock_quantity'] . ' unit(s) are available.');
        }

        $database->table('sales')->insert([
            'product_id' => $productId,
            'customer_id' => $customerId,
            'sold_by' => $userId,
            'quantity' => $quantity,
            'total_price' => number_format((float) $product['price'] * $quantity, 2, '.', ''),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        if ($database->transStatus() === false) {
            $database->transRollback();
            return redirect()->back()->withInput()->with('error', 'The sale could not be saved. Please try again.');
        }

        $database->transCommit();

        return redirect()->to(site_url('sales'))->with('success', 'Sale recorded and stock updated successfully.');
    }

    private function invalidForm()
    {
        return redirect()->back()->withInput()->with('formInput', $this->request->getPost())->with('errors', $this->validator->getErrors());
    }
}
