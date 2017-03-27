<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Recipe::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->title,
        'description' => $faker->paragraph,
        'cover' => $faker->imageUrl,
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'featured' => $faker->boolean
    ];
});

$factory->define(App\Category::class, function (Faker\Generator $faker) {
    $title = $faker->title;
    $slug = str_replace(' ', '-', strtolower($title));
    return [
        'title' => $title,
        'slug' => $slug
    ];
});
