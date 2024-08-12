<?php

use App\Keyword;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(AccountsSeeder::class);
        // $this->call(FleetSeeder::class);
        // $this->call(DispatcherSeeder::class);
        // $this->call(ServiceTypesTableSeeder::class);
        // $this->call(DocumentsTableSeeder::class);
        // $this->call(SettingsTableSeeder::class);
        // $this->call(DemoSeeder::class);
        $this->call(ModuleSeeder::class);
        $this->call(RoleSeeder::class);
        // $this->call(AdminsTableSeeder::class); //Senstive Part Not Run in Production
        $this->call(LanguageSeeder::class);
        $this->call(KeywordSeeder::class);
        $this->call(CancellationReasonSeeder::class);
        $this->call(FaqSeeder::class);
        $this->call(OnboardingSeeder::class);
        $this->call(PageContentSeeder::class);
    }
}
