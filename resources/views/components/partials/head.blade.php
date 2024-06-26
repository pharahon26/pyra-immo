
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ config('app.name', 'Pyra Immo') }}</title>

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

<!-- Scripts -->
@vite(['resources/css/app.css', 'resources/js/app.js'])
<script src="{{asset('js/customer.js')}}" defer></script>
<script src="{{asset('js/customer-dropdown.js')}}" defer></script>

<style>
    .gradient {
      background: linear-gradient(90deg, #daae51 0%, #ff7f27 100%);
      /* background: linear-gradient(90deg, #d53369 0%, #daae51 100%); */
    }
  </style>

<!-- Styles -->
@livewireStyles


