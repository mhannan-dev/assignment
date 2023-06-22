<?php

if (!function_exists('formatDate')) {
    function formatDate($date)
    {
        return \Carbon\Carbon::parse($date)->format('Y-m-d');
    }
}

if (!function_exists('checkUserType')) {
    function checkUserType($userType)
    {
        $authenticatedUser = auth()->user();
        return $authenticatedUser && $authenticatedUser->type === $userType;
    }
}
