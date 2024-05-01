<?php

use Illuminate\Http\Response;

it('store a valid externalDataBase', function () {

    $connexion = [
        "database" => "link-analyse-service",
        "host" => "localhost",
        "driver" => "mysql",
        "port" => "3306",
        "name" => "group_profile",
        "username" => "root",
        "password" => "root"
    ];

    $this->postJson(route('connections.store'), $connexion)
        ->assertStatus(Response::HTTP_OK)
        ->assertOk();
});
