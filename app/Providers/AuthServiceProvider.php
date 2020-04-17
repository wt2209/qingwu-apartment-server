<?php

namespace App\Providers;

use App\Models\Area;
use App\Models\Category;
use App\Models\ChargeRule;
use App\Models\Company;
use App\Models\FeeType;
use App\Models\Person;
use App\Models\Record;
use App\Models\Room;
use App\Policies\AreaPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\ChargeRulePolicy;
use App\Policies\CompanyPolicy;
use App\Policies\FeeTypePolicy;
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
        ChargeRule::class => ChargeRulePolicy::class,
        FeeType::class => FeeTypePolicy::class,
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
