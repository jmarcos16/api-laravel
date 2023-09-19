<?php

use App\Models\User;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;

it('should be list all users', function () {
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

it('should be able to create a new user', function () {
    $response = postJson(route('users.create'), [
        'name' => 'John Doe',
        'email' => 'test@tess.com',
        'password' => '123456',
        'confirm_password' => '123456'
    ])->assertCreated();

    $response->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'email',
            'updated_at',
        ],
    ]);

    assertDatabaseHas('users', ['email' => 'test@tess.com']);
    assertDatabaseCount('users', 1);

});

test('validate if name is require to create a new user', function () {
    postJson(route('users.create'), [
        'email' => 'test@test.com',
        'password' => '123456',
        'confirm_password' => '123456'
    ])->assertJsonValidationErrors('name');
});
