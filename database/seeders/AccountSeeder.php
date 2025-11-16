<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accounts = [

            // ASSETS 1xxx
            ['code' => '1001', 'name' => 'Glory', 'type' => 'asset'],

            // LIABILITIES 2xxx
            ['code' => '2001', 'name' => 'Accounts Payable', 'type' => 'liability'],
            ['code' => '2002', 'name' => 'Fee Refund Payable', 'type' => 'liability'],

            // EQUITY 3xxx
            ['code' => '3001', 'name' => 'Owner Equity', 'type' => 'equity'],

            // REVENUE 4xxx
            ['code' => '4001', 'name' => 'Student Fee Revenue', 'type' => 'revenue'],
            ['code' => '4002', 'name' => 'Book Sale Revenue', 'type' => 'revenue'],

            // EXPENSES 5xxx
            ['code' => '5001', 'name' => 'Salary Expense', 'type' => 'expense'], // use next feature 
            ['code' => '5002', 'name' => 'Utilities Expense', 'type' => 'expense'],
            ['code' => '5003', 'name' => 'Book Purchase Expense', 'type' => 'expense'],
            ['code' => '5004', 'name' => 'Miscellaneous Expense', 'type' => 'expense'],
        ];

        foreach ($accounts as $acc) {
            Account::create($acc);
        }
    }
}
