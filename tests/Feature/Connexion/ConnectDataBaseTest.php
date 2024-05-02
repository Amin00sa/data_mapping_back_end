<?php

use App\Enums\DriverEnum;
use Illuminate\Http\Response;

it('connect a database', function () {
    $connexion = [
        "database" => "link-analyse-service",
        "host"     => "localhost",
        "driver"   => "mysql",
        "port"     => "3306",
        "username" => "root",
        "password" => "root",
    ];

    $this->postJson(route('connections.connect'), $connexion)
        ->assertStatus(Response::HTTP_OK)
        ->assertOk();
});

it('connect an invalid externalDataBase', function () {
    $connexion = [
        'database' => fake()->word,
        'host'     => fake()->name,
        'driver'   => fake()->randomElement(getEnumValues(DriverEnum::class)),
        'port'     => fake()->numberBetween(0, 10000),
        'name'     => fake()->name,
        'username' => fake()->name,
        'password' => fake()->password,
    ];
    $this->postJson(route('connections.connect'), $connexion)
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure(
            [
                'status' => [
                    'errors',
                ],
            ]
        );
});
