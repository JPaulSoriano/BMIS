<?php

namespace Database\Seeders;

use App\User;
use Illuminate\Database\Seeder;

class BusPointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $auth = User::role('admin')->has('companyProfile')->with('companyProfile')->get()->flatten()->pluck('companyProfile')->flatten()->pluck('id');
        $company_id = $auth->random();

        $passengers = User::role('passenger')->get();
        $passengers->each(function ($passenger) use ($company_id) {
            if (!empty($passenger->busPoints) && $passenger->busPoints->find($company_id)) {
                $passenger->busPoints()->updateExistingPivot($company_id, ['points' => mt_rand(10, 999)]);
            } else {
                $passenger->busPoints()->attach([$company_id => ['points' => mt_rand(10, 999)]]);
            }
        });
    }
}
