<?php
namespace FilamentPro\Features\Actions;

use Lorisleiva\Actions\Concerns\AsAction;

class DeleteUser
{
    use AsAction;

    public function handle($user)
    {
        if(method_exists($user, 'deleteProfilePhoto')) $user->deleteProfilePhoto();
        $user->tokens->each->delete();
        $user->delete();
    }
}
