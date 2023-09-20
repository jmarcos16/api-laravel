<?php

use App\Models\User;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;
use function PHPUnit\Framework\assertCount;

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


test('validate if name is string to create a new user', function () {
    postJson(route('users.create'), [
        'name' => 123,
        'email' => 'test@test.com',
        'password' => '123456',
        'confirm_password' => '123456'
    ])->assertJsonValidationErrors('name');
});


test('validate if name contains max 255 character', function () {
    postJson(route('users.create'), [
        'name' => str_repeat('a', 256),
        'email' => 'test@test.com',
        'password' => '123456',
        'confirm_password' => '123456'
    ])->assertJsonValidationErrors('name');
});

test('validate if email is require to create a new user', function () {
    postJson(route('users.create'), [
        'name' => 'Fake Name',
        'password' => '123456',
        'confirm_password' => '123456'
    ])->assertJsonValidationErrors('email');
});

test('validate if email is valid to create a new user', function () {
    postJson(route('users.create'), [
        'name' => 'Fake Name',
        'email' => 'duawidnai',
        'password' => '123456',
        'confirm_password' => '123456'
    ])->assertJsonValidationErrors('email');
});

test('validate if email is unique to create a new user', function () {
    User::factory()->create(['email' => 'test@test.com']);

    postJson(route('users.create'), [
        'name' => 'Fake Name',
        'email' => 'test@test.com',
        'password' => '123456',
        'confirm_password' => '123456'
    ])->assertJsonValidationErrors('email');
});

test('validate if email contains max 255 character', function () {
    postJson(route('users.create'), [
        'name' => 'Fake Name',
        'email' => str_repeat('a', 256) . "@tes.com",
        'password' => '123456',
        'confirm_password' => '123456'
    ])->assertJsonValidationErrors('email');
});

test('validate if password is require to create a new user', function () {
    postJson(route('users.create'), [
        'name' => 'Fake Name',
        'email' => 'test@test.com',
        'confirm_password' => '123456'
    ])->assertJsonValidationErrors('password');
});

test('validate if password contains min 6 character', function () {
    postJson(route('users.create'), [
        'name' => 'Fake Name',
        'email' => 'test@test.com',
        'password' => '123',
        'confirm_password' => '123'
    ])->assertJsonValidationErrors('password');
});

test('validate if password contains max 255 character', function () {
    postJson(route('users.create'), [
        'name' => 'Fake Name',
        'email' => 'test@test.com',
        'password' => str_repeat('a', 256),
        'confirm_password' => str_repeat('a', 256)
    ])->assertJsonValidationErrors('password');
});

test('validate if confirm_password is require to create a new user', function () {
    postJson(route('users.create'), [
        'name' => 'John Doe',
        'email' => 'test@tess.com',
        'password' => '123456'
    ])->assertJsonValidationErrors('confirm_password');
});

test('validate if confirm_password is same as password to create a new user', function () {
    postJson(route('users.create'), [
        'name' => 'John Doe',
        'email' => 'test@tess.com',
        'password' => '123456',
        'confirm_password' => '123456s'
    ])->assertJsonValidationErrors('confirm_password');
});


it('should be able  find a user by id', function () {
    $user = User::factory()->create();
    $response = getJson(route('users.find', ['user' => $user->id]))->assertOk();
    $response->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'email',
            'updated_at',
        ],
    ]);
});


it('should be able update a user', function () {
    $user = User::factory()->create();
    $response = putJson(route('users.update', ['user' => $user->id]), [
        'name' => 'John Doe',
        'email' => 'test@dwindiuo'
    ]);

    $response->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'email',
            'updated_at',
        ],
    ]);

    assertDatabaseHas('users', ['email' => 'test@dwindiuo']);
    assertDatabaseCount('users', 1);
});

test('validate if name is require to update a user', function () {
    $user = User::factory()->create();

    putJson(route('users.update', ['user' => $user->id]), [
        'email' => 'test@dwindiuo'
    ])->assertJsonValidationErrors('name');

    assertDatabaseHas('users', ['email' => $user->email]);
});

test('validate if name is string to update a user', function () {
    $user = User::factory()->create();

    putJson(route('users.update', ['user' => $user->id]), [
        'name' => 123,
        'email' => 'test@dwindiuo'
    ])->assertJsonValidationErrors('name');

    assertDatabaseHas('users', ['email' => $user->email]);
});

test('validate if name contains max 255 character to update a user', function () {
    $user = User::factory()->create();

    putJson(route('users.update', ['user' => $user->id]), [
        'name' => str_repeat('a', 256),
        'email' => 'test@dwindiuo'
    ])->assertJsonValidationErrors('name');

    assertDatabaseHas('users', ['email' => $user->email]);
});

test('validate if email is require to update a user', function () {
    $user = User::factory()->create();

    putJson(route('users.update', ['user' => $user->id]), [
        'name' => 'Fake Name',
    ])->assertJsonValidationErrors('email');

    assertDatabaseHas('users', ['email' => $user->email]);
});

test('validate if email is valid to update a user', function () {
    $user = User::factory()->create();

    putJson(route('users.update', ['user' => $user->id]), [
        'name' => 'Fake Name',
        'email' => 'duawidnai',
    ])->assertJsonValidationErrors('email');

    assertDatabaseHas('users', ['email' => $user->email]);
});

test('validate if email is unique to update a user', function () {
    $user = User::factory()->create();
    $user1 = User::factory()->create();

    putJson(route('users.update', ['user' => $user->id]), [
        'name' => 'Fake Name',
        'email' => $user1->email,
    ])->assertJsonValidationErrors('email');

    assertCount(1, User::where('email', $user1->email)->get());
});
