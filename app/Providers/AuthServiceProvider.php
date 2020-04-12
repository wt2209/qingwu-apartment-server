<?php

namespace App\Providers;

use App\Models\Area;
use App\Models\Category;
use App\Models\Company;
use App\Models\Person;
use App\Models\Record;
use App\Models\Room;
use App\Policies\AreaPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\CompanyPolicy;
use App\Policies\PersonPolicy;
use App\Policies\RecordPolicy;
use App\Policies\RoomPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        Area::class => AreaPolicy::class,
        Room::class => RoomPolicy::class,
        Category::class => CategoryPolicy::class,
        Company::class => CompanyPolicy::class,
        Record::class => RecordPolicy::class,
        Person::class => PersonPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
