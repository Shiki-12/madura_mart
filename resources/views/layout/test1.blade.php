<!DOCTYPE html>
<html lang="id">
<head>
    <title>Website Saya - @yield('title')</title>
</head>
<body>
    <header>
        <h1>Ini Navbar (Selalu Sama)</h1>
    </header>

    <main>
        {{-- Di sinilah konten yang berubah-ubah akan ditaruh --}}
        @yield('content')
    </main>

    <footer>
        <p>Ini Footer (Selalu Sama)</p>
    </footer>
</body>
</html>