<?php

use Illuminate\Support\Facades\Session;

if (! function_exists('base_url')) {
    /**
     * CodeIgniter-style base_url() shim so ported views keep working unchanged.
     * Returns the application root URL with a trailing slash, optionally
     * appending a relative URI.
     */
    function base_url(string $uri = ''): string
    {
        return rtrim(url('/'), '/') . '/' . ltrim($uri, '/');
    }
}

if (! function_exists('form_error')) {
    /**
     * CodeIgniter-style form_error() shim. Returns the first validation error
     * for a field wrapped in the delimiters the original app used.
     */
    function form_error(string $field, string $prefix = '<div class="error">', string $suffix = '</div>'): string
    {
        $errors = Session::get('errors');

        if ($errors && $errors->has($field)) {
            return $prefix . e($errors->first($field)) . $suffix;
        }

        return '';
    }
}
