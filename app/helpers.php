<?php

use Illuminate\Support\Str;
use App\Category;

function slugExists($slug, $model) {
    switch ($model) {
        case 'Category':
            $result = Category::where('slug', $slug)->first();
            break;
    }
    return $result;
}

function getSlug($string, $model) {
    // we generate the slug starting from the given string
    $slug = Str::slug($string, '-');
    // we make a copy of the slug
    $new_slug = $slug;
    // we check if the generated slug already exists in the corresponding table
    $slug_found = slugExists($new_slug, $model);
    $counter = 1;
    while ($slug_found) {
        // if the generated slug already exists in the corresponding table,
        // we modify the slug by adding a number to it at the end
        $new_slug = $slug . '-' . $counter;
        $counter++;
        // we check if the modified slug already exists in the corresponding table
        $slug_found = slugExists($new_slug, $model);
    }
    // we return a slug which certainly does not already exist in the corresponding table
    return $new_slug;
}
