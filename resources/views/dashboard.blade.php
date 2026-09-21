<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel - Dashboard</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <style>
        body { font-family: 'Figtree', sans-serif; }
        .bg-startbootstrap {
            background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.3) 0%, rgba(0, 0, 0, 0.6) 100%), url('{{ asset('assets/img/bg-masthead.jpg') }}'), url('/practica/public/assets/img/bg-masthead.jpg');
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: scroll;
            background-size: cover;
        }
    </style>
</head>
<body class="font-sans antialiased min-h-screen flex flex-col bg-gray-100">

    <!-- Navigation Bar -->
    <nav class="bg-white border-b border-gray-100 relative z-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <a href="#">
                            <svg class="block h-9 w-auto fill-current text-gray-800" viewBox="0 0 62 65" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M61.8548 14.6253C61.8105 14.49 61.7346 14.368 61.6329 14.2691L47.5312 0.548487C47.3377 0.358245 47.0754 0.25206 46.8021 0.25206H14.8698C14.5966 0.25206 14.3343 0.358245 14.1408 0.548487L0.0390625 14.2691C-0.0626305 14.368 -0.138547 14.49 -0.182813 14.6253C-0.227079 14.7607 -0.238478 14.9056 -0.216094 15.0483C-0.19371 15.1909 -0.13824 15.3268 -0.0541783 15.4452C0.0298836 15.5636 0.140026 15.6607 0.267344 15.7287L30.3444 31.7825C30.6019 31.9199 30.9069 31.9199 31.1644 31.7825L61.2415 15.7287C61.3688 15.6607 61.4789 15.5636 61.563 15.4452C61.647 15.3268 61.7025 15.1909 61.7249 15.0483C61.7473 14.9056 61.7359 14.7607 61.6916 14.6253H61.8548Z" fill="#FF2D20"/>
                            </svg>
                        </a>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <a href="#" class="inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out">
                            Dashboard
                        </a>
                    </div>
                </div>

                <!-- Settings Dropdown / Logout -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <div class="relative flex items-center space-x-4">
                        <span class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white">
                            {{ Auth::user()->name }}
                        </span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-gray-500 hover:text-gray-700 font-medium">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Heading -->
    <header class="bg-white shadow relative z-10">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </div>
    </header>

    <!-- Page Content con imagen de fondo completa de Start Bootstrap -->
    <main class="flex-1 bg-startbootstrap py-16 px-4 sm:px-6 lg:px-8 flex flex-col justify-start items-center">
        <div class="w-full max-w-7xl">
            <div class="bg-white/95 backdrop-blur-md overflow-hidden shadow-xl sm:rounded-xl border border-white/40">
                <div class="p-6 text-gray-900 font-semibold text-lg flex items-center justify-between">
                    <span>You're logged in!</span>
                    <span class="text-xs font-normal text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                        Start Bootstrap Grayscale
                    </span>
                </div>
            </div>
        </div>
    </main>

</body>
</html>
