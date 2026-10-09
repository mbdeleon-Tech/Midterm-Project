<?php

namespace Tests\App\Feature;

use CodeIgniter\Test\CIUnitTestCase;

class SalesAndUploadsTest extends CIUnitTestCase
{
    public function testSalesWorkflowProtectsStockAndUsesTransaction(): void
    {
        $sales = file_get_contents(APPPATH . 'Controllers/Sales.php');

        $this->assertStringContainsString('transBegin()', $sales);
        $this->assertStringContainsString("where('stock_quantity >=', \$quantity)", $sales);
        $this->assertStringContainsString('stock_quantity - ', $sales);
        $this->assertStringContainsString('affectedRows() !== 1', $sales);
        $this->assertStringContainsString('transRollback()', $sales);
        $this->assertStringContainsString('transCommit()', $sales);
        $this->assertStringContainsString("'total_price'", $sales);
    }

    public function testSalesHistoryJoinsAllRelatedRecords(): void
    {
        $model = file_get_contents(APPPATH . 'Models/SaleModel.php');
        $view = file_get_contents(APPPATH . 'Views/sales/index.php');

        $this->assertStringContainsString("join('products'", $model);
        $this->assertStringContainsString("join('customers'", $model);
        $this->assertStringContainsString("join('users'", $model);
        $this->assertStringContainsString("\$sale['product_name']", $view);
        $this->assertStringContainsString("\$sale['customer_name']", $view);
        $this->assertStringContainsString("\$sale['staff_name']", $view);
        $this->assertStringContainsString("\$sale['total_price']", $view);
    }

    public function testUploadsAreValidatedAndPreparedForDisplay(): void
    {
        $products = file_get_contents(APPPATH . 'Controllers/Products.php');
        $users = file_get_contents(APPPATH . 'Controllers/Users.php');
        $image = file_get_contents(APPPATH . 'Libraries/DisplayImage.php');

        $this->assertStringContainsString('max_size[image,2048]', $products);
        $this->assertStringContainsString('is_image[image]', $products);
        $this->assertStringContainsString('max_size[avatar,2048]', $users);
        $this->assertStringContainsString('is_image[avatar]', $users);
        $this->assertStringContainsString('->fit($width, $height', $image);
        $this->assertFileExists(FCPATH . 'uploads/product-placeholder.svg');
        $this->assertFileExists(FCPATH . 'uploads/placeholder.svg');
    }

    public function testValidationCoversRequiredFields(): void
    {
        $products = file_get_contents(APPPATH . 'Controllers/Products.php');
        $customers = file_get_contents(APPPATH . 'Controllers/Customers.php');
        $users = file_get_contents(APPPATH . 'Controllers/Users.php');

        $this->assertStringContainsString('greater_than_equal_to[0]', $products);
        $this->assertStringContainsString('valid_email', $customers);
        $this->assertStringContainsString('is_unique[users.username]', $users);
    }
}
