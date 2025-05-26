<aside class="w-64 bg-white shadow-lg p-4 space-y-2">
    <div class="padding-4 mb-6 border-b">
        <h2 class="text-xl font-bold mb-4">Venta de streaming</h2>
    </div>
    <nav class="flex flex-col space-y-2">
        <span class="text-gray-500 mb-2 block">Menu</span>
        <ul class="mb-6 flex flex-col gap-4">
            <li>
                <a href="{{ route('home') }}" class="block p-2 rounded hover:bg-gray-100 font-semibold {{ request()->routeIs('home') ? 'bg-gray-100 text-blue-600' : '' }}">Inicio</a>
            </li>
            <li>
                <a href="{{ route('dashboard') }}" class="block p-2 rounded hover:bg-gray-100 font-semibold {{ request()->routeIs('dashboard') ? 'bg-gray-100 text-blue-600' : '' }}">Movimientos</a>
            </li>
            <li>
                <a href="{{ route('cuentas') }}" class="block p-2 rounded hover:bg-gray-100 font-semibold {{ request()->routeIs('cuentas') ? 'bg-gray-100 text-blue-600' : '' }}">Cuentas</a>
            </li>
            <li>
                <a href="{{ route('clientes') }}" class="block p-2 rounded hover:bg-gray-100 font-semibold {{ request()->routeIs('clientes') ? 'bg-gray-100 text-blue-600' : '' }}">Clientes</a>
            </li>
            <li>
                <a href="{{ route('servicios') }}" class="block p-2 rounded hover:bg-gray-100 font-semibold {{ request()->routeIs('servicios') ? 'bg-gray-100 text-blue-600' : '' }}">Servicios</a>
            </li>
        </ul>

    </nav>

</aside>
