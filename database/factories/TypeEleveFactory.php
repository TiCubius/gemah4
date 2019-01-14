<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\TypeEleve::class, function(Faker $faker) {
    return [
        "nom" => $faker->word,
    ];
});
