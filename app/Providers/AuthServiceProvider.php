<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Company;
use App\Models\Person;
use App\Models\Record;
use App\Models\Room;
use App\Policies\AreasPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        Room::class => AreasPolicy::class,
        Category::class => AreasPolicy::class,
        Company::class => AreasPolicy::class,
        Record::class => AreasPolicy::class,
        Person::class => AreasPolicy::class,
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
