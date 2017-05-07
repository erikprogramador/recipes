<?php

function make($class, $attributes = []) {
    return factory($class)->make($attributes);
}

function makeMany($class, $quantity = 2,  $attributes = []) {
    return factory($class, $quantity)->make($attributes);
}

function create($class, $attributes = []) {
    return factory($class)->create($attributes);
}

function createMany($class, $quantity = 2,  $attributes = []) {
    return factory($class, $quantity)->create($attributes);
}
