<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SmartWaste') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/">
                    <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="24" height="24" viewBox="0 0 6.827 6.827" class="w-6 h-6">
  <!-- Optional: You can add your custom classes or inline styling here -->
  <defs>
    <clipPath id="id0">
      <path d="M3.413 0a3.413 3.413 0 1 1 0 6.827 3.413 3.413 0 0 1 0-6.827z"/>
    </clipPath>
    <style>
      .fil2{fill:none}.fil21{fill:#164d1a}.fil5{fill:#1b1b1b}.fil3{fill:#212121}.fil8{fill:#263238}
      .fil13{fill:#37474f}.fil4{fill:#424242}.fil24{fill:#4b772d}.fil6{fill:#558b2f}.fil14{fill:#595959}
      .fil1{fill:#ab47bc}.fil9{fill:#add7fa}.fil20{fill:#ffc400}.fil10,.fil15{fill:#212121;fill-rule:nonzero}
      .fil10{fill:#37474f}
    </style>
  </defs>
  <g id="Layer_x0020_1">
    <path d="M3.413 0a3.413 3.413 0 1 1 0 6.827 3.413 3.413 0 0 1 0-6.827z" style="fill:#ba68c8"/>
    <!-- Inserted paths shortened for brevity -->
    <!-- All your <g>, <path>, etc., from your custom logo go here -->
  </g>
</svg>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
