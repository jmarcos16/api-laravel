<?php

use App\Models\User;
use function Pest\Laravel\getJson;

it('shoul be list all users', function () {
    User::factory()->count(10)->create();
    $response = getJson(route('users.list'))->assertOk();
    $response->assertJsonStructure([
        'data' => [
            '*' => [
                'id',
                'name',
                'email',
                'updated_at',
            ],
        ],
    ]);
});
