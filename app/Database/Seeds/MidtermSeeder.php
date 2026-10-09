<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MidtermSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('products')->insertBatch([
            ['name' => 'Wireless Barcode Scanner', 'price' => 1899.00, 'stock_quantity' => 18, 'image' => null, 'created_at' => '2026-10-01 08:00:00'],
            ['name' => 'Thermal Receipt Paper 10-Pack', 'price' => 349.00, 'stock_quantity' => 44, 'image' => null, 'created_at' => '2026-10-01 08:10:00'],
            ['name' => 'USB Cash Drawer', 'price' => 2450.00, 'stock_quantity' => 9, 'image' => null, 'created_at' => '2026-10-01 08:20:00'],
            ['name' => 'Countertop Card Reader Stand', 'price' => 790.00, 'stock_quantity' => 15, 'image' => null, 'created_at' => '2026-10-01 08:30:00'],
            ['name' => 'Inventory Label Roll', 'price' => 225.00, 'stock_quantity' => 36, 'image' => null, 'created_at' => '2026-10-01 08:40:00'],
            ['name' => 'Compact Thermal Printer', 'price' => 3299.00, 'stock_quantity' => 7, 'image' => null, 'created_at' => '2026-10-01 08:50:00'],
        ]);

        $this->db->table('customers')->insertBatch([
            ['full_name' => 'Alyssa Santos', 'email' => 'alyssa.santos@example.com', 'phone' => '0917 248 3106', 'created_at' => '2026-10-01 09:00:00'],
            ['full_name' => 'Daniel Reyes', 'email' => 'daniel.reyes@example.com', 'phone' => '0928 517 4420', 'created_at' => '2026-10-01 09:15:00'],
            ['full_name' => 'Mikaela Cruz', 'email' => 'mikaela.cruz@example.com', 'phone' => '0995 630 1184', 'created_at' => '2026-10-01 09:30:00'],
            ['full_name' => 'Paolo Mendoza', 'email' => 'paolo.mendoza@example.com', 'phone' => '0918 761 9052', 'created_at' => '2026-10-01 09:45:00'],
            ['full_name' => 'Trisha Lim', 'email' => 'trisha.lim@example.com', 'phone' => '0906 482 7731', 'created_at' => '2026-10-01 10:00:00'],
            ['full_name' => 'Gabriel Torres', 'email' => 'gabriel.torres@example.com', 'phone' => '0927 194 6685', 'created_at' => '2026-10-01 10:15:00'],
        ]);

        $password = password_hash('Northstar123!', PASSWORD_DEFAULT);
        $this->db->table('users')->insertBatch([
            ['username' => 'admin.marc', 'full_name' => 'Marco De Leon', 'password' => $password, 'avatar' => null, 'created_at' => '2026-10-01 08:00:00'],
            ['username' => 'cashier.ana', 'full_name' => 'Ana Villanueva', 'password' => $password, 'avatar' => null, 'created_at' => '2026-10-01 08:15:00'],
            ['username' => 'cashier.joel', 'full_name' => 'Joel Garcia', 'password' => $password, 'avatar' => null, 'created_at' => '2026-10-01 08:30:00'],
            ['username' => 'stock.ella', 'full_name' => 'Ella Navarro', 'password' => $password, 'avatar' => null, 'created_at' => '2026-10-01 08:45:00'],
            ['username' => 'manager.luis', 'full_name' => 'Luis Ramos', 'password' => $password, 'avatar' => null, 'created_at' => '2026-10-01 09:00:00'],
            ['username' => 'support.nica', 'full_name' => 'Nica Flores', 'password' => $password, 'avatar' => null, 'created_at' => '2026-10-01 09:15:00'],
        ]);

        $this->db->table('sales')->insertBatch([
            ['product_id' => 2, 'customer_id' => 1, 'sold_by' => 2, 'quantity' => 2, 'total_price' => 698.00, 'created_at' => '2026-10-08 09:10:00'],
            ['product_id' => 1, 'customer_id' => 3, 'sold_by' => 1, 'quantity' => 1, 'total_price' => 1899.00, 'created_at' => '2026-10-08 10:25:00'],
            ['product_id' => 5, 'customer_id' => null, 'sold_by' => 2, 'quantity' => 4, 'total_price' => 900.00, 'created_at' => '2026-10-08 13:40:00'],
            ['product_id' => 4, 'customer_id' => 5, 'sold_by' => 3, 'quantity' => 1, 'total_price' => 790.00, 'created_at' => '2026-10-08 15:05:00'],
        ]);
    }
}
