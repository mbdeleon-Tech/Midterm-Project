<?php

namespace Tests\App\Feature;

use CodeIgniter\Test\CIUnitTestCase;

class ArchitectureTest extends CIUnitTestCase
{
    public function testRequiredCrudAndSalesRoutesExist(): void
    {
        $routes = file_get_contents(APPPATH . 'Config/Routes.php');

        foreach (['products', 'customers', 'users'] as $resource) {
            $this->assertStringContainsString("get('{$resource}'", $routes);
            $this->assertStringContainsString("get('{$resource}/new'", $routes);
            $this->assertStringContainsString("post('{$resource}'", $routes);
            $this->assertStringContainsString("get('{$resource}/(:num)/edit'", $routes);
            $this->assertStringContainsString("post('{$resource}/(:num)'", $routes);
            $this->assertStringContainsString("post('{$resource}/(:num)/delete'", $routes);
        }

        $this->assertStringContainsString("get('sales/new'", $routes);
        $this->assertStringContainsString("post('sales'", $routes);
        $this->assertStringContainsString("get('sales'", $routes);
    }

    public function testModelsMapToAllRequiredTables(): void
    {
        $models = [
            'ProductModel.php' => 'products',
            'CustomerModel.php' => 'customers',
            'UserModel.php' => 'users',
            'SaleModel.php' => 'sales',
        ];

        foreach ($models as $file => $table) {
            $source = file_get_contents(APPPATH . 'Models/' . $file);
            $this->assertStringContainsString("protected \$table = '{$table}'", $source);
        }
    }

    public function testDatabaseExportContainsSchemaRelationshipsAndSeeds(): void
    {
        $sql = file_get_contents(ROOTPATH . 'database/midterm_pos.sql');

        foreach (['products', 'customers', 'users', 'sales'] as $table) {
            $this->assertStringContainsString("CREATE TABLE `{$table}`", $sql);
        }

        $this->assertStringContainsString('FOREIGN KEY (`product_id`) REFERENCES `products`', $sql);
        $this->assertStringContainsString('FOREIGN KEY (`customer_id`) REFERENCES `customers`', $sql);
        $this->assertStringContainsString('FOREIGN KEY (`sold_by`) REFERENCES `users`', $sql);
        $this->assertStringContainsString('$2y$10$', $sql);
        $this->assertStringContainsString('Wireless Barcode Scanner', $sql);
    }

    public function testAutomaticRoutingIsDisabled(): void
    {
        $routing = file_get_contents(APPPATH . 'Config/Routing.php');
        $this->assertStringContainsString('public bool $autoRoute = false', $routing);
    }
}
