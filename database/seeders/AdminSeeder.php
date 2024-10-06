<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\BranchOffice;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = BranchOffice::select('id')->orderBy('id', 'asc')->get();

        DB::table('admins')->insert([
            [
                'branch_id' => $branches[0]->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'branch_id' => $branches[1]->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
