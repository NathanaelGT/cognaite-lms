<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            {{ isset($title) ? "{$title} - " : null }} Cognaite LMS
        </title>
        @stack('head')
    </head>
    <body>
        {{ $slot }}
    </body>
</html>
