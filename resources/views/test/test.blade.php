{{-- 1. Beritahu Blade untuk pakai layout 'app.blade.php' --}}
@extends('layout.test1')

{{-- 2. Mengisi @yield('title') dengan teks 'Halaman Beranda' --}}
@section('title', 'Halaman Beranda')

{{-- 3. Mengisi @yield('content') dengan blok HTML --}}
@section('content')
    <h2>Selamat Datang di Halaman Beranda!</h2>
    <p>Ini adalah konten spesifik untuk halaman beranda.</p>
    <p>Header dan Footer otomatis diambil dari layout.</p>
@endsection