@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white p-4 rounded shadow">🧾 Reportes</div>
        <div class="bg-white p-4 rounded shadow">📈 Estadísticas</div>
        <div class="bg-white p-4 rounded shadow">👥 Usuarios</div>
    </div>

    <div class="mt-6 bg-white p-6 rounded shadow">
        <h2 class="text-xl font-semibold mb-2">Bienvenido</h2>
        <p>Este es tu panel de control.</p>
    </div>
@endsection
