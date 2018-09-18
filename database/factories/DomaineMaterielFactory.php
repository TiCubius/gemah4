<?php

use Faker\Generator as Faker;

$factory->define(App\Models\DomaineMateriel::class, function (Faker $faker) {
    return [
        "nom" => $faker->word
    ];
});
