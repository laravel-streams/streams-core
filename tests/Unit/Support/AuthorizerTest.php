<?php

use Tests\TestCase;
use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\Entry\EntryPresenter;
use Anomaly\Streams\Platform\Support\Facades\Decorator;

class AuthorizerTest extends TestCase
{
    use \Illuminate\Foundation\Testing\DatabaseTransactions;


    public function testSuccessfullyAuthorizeAnAuthorizedUserWithAPermission()
    {
        $user = $this->user();

        $this->assertTrue($this->authorizer()->authorize('anomaly.module.users::users.read', $user));
    }

    /**
     * @todo authorizer always returning true?
     */
    public function testSuccessfullyNotAuthorizeAnUnauthorizedUserWithAPermission()
    {
        $this->markTestIncomplete();
        $user = $this->user();
        $this->assertFalse($this->authorizer()->authorize('anomaly.module.users::users.delete', $user));
    }

    public function testSuccessfullyAuthorizeAnAuthorizedUserWithARoleContainingAPermission()
    {
        $user = $this->user();
        $role = $this->role(['permissions' => "anomaly.module.users::users.write"]);
        
        $user = $this->forRole($user, $role);

        $this->assertTrue($this->authorizer()->authorize('anomaly.module.users::users.write', $user));
    }

    /**
     * @return \Anomaly\Streams\Platform\Support\Authorizer
     */
    protected function authorizer()
    {
        return app(\Anomaly\Streams\Platform\Support\Authorizer::class);
    }

    /**
     * @todo should we be binding the contracts to concrete models in the module SPs by default? I do this locally. See UsersModuleServiceProvider.
     *
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    protected function user($attributes = [])
    {
        loadAddonFactory('anomaly/users-module', 'User');
        return factory(\Anomaly\UsersModule\User\UserModel::class)->create($attributes);
    }

    protected function role($attributes = [])
    {
        loadAddonFactory('anomaly/users-module', 'Role');
        return factory(\Anomaly\UsersModule\Role\RoleModel::class)->create($attributes);
    }

    /**
     * @param $user
     * @param $role
     * @return mixed
     */
    protected function forRole($user, $role)
    {
        $user->roles()->attach($role);

        return $user;
    }
}
