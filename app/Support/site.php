<?php

if (! function_exists('isMainSite')) {
    function isMainSite(): bool
    {
        return config('site.type') === 'main';
    }
}

if (! function_exists('isFacultySite')) {
    function isFacultySite(): bool
    {
        return config('site.type') === 'faculty';
    }
}
