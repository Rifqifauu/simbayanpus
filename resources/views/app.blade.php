<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    @vite(['resources/js/app.js'])
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link rel="icon" type="image" href="storage/logo-balaiyanpus.svg">

    
    @inertiaHead
  </head>
  <body>
    @inertia
  </body>
</html>