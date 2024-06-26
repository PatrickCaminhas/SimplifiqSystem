<?php

namespace App\Listeners;

use Stancl\Tenancy\Events\TenantCreated;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateDefaultUserForNewTenant
{
    /**
     * Create the event listener.
     */

     
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    /**
     * Handle the event.
     *
     * @param TenantCreated $event
     * @return void
     */
    public function handle(TenantCreated $event)
    {
        // Utilize o contexto de tenant
        tenancy()->initialize($event->tenant);

        // Crie o usuário padrão
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
