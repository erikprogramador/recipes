<?php

function make($class, $overrides = [], $quantity = 1) {
    return factory($class, $quantity)->make($overrides);
}

function create($class, $overrides = [], $quantity = 1) {
    return factory($class, $quantity)->create($overrides);
}
