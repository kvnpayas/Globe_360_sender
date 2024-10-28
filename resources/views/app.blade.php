<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  {{-- Company Logo --}}
  <link rel="icon" href="{{ asset('img/tei_logo.png') }}" type="image/png" sizes="16x16">

  <title>TEI SMS Monitoring</title>

  @vite('resources/js/app.js')
  @inertiaHead
</head>

<body>
  @inertia
</body>

</html>
