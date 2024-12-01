
<nav class="border-gray-200 text-white nav">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="{{url('/')}}" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{Vite::asset('resources/img/factura.png')}}" class="h-8" alt="Flowbite Logo" />
            <span class="self-center text-1xl font-semibold whitespace-nowrap">MVP Facturador</span>
        </a>
        <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
            <button type="button"
                class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300"
                id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                data-dropdown-placement="bottom">
                <span class="sr-only">Open user menu</span>
                <img class="w-8 h-8 rounded-full" src="{{ Vite::asset('resources/img/avatar5.png') }}" alt="user photo">
            </button>
            <!-- Dropdown menu -->
            <div class="z-50 hidden my-4 text-base list-none bg-gray-700 divide-y divide-gray-100 rounded-lg shadow"
                id="user-dropdown">
                <div class="px-4 py-3">
                    <span class="block text-sm text-white">Hola  {{Auth::user()->name}}</span>
                    <span class="block text-sm  text-white truncate">{{Auth::user()->email}}</span>
                </div>
                <ul class="py-2" aria-labelledby="user-menu-button">
                    <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <a class="block px-4 py-2 text-sm text-white hover:bg-red-600">
                        <button type="submit">Salir</button></a>
                    </form>
                    </li>
                </ul>
            </div>
            <button data-collapse-toggle="navbar-user" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-black-400 rounded-lg md:hidden hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-gray-200"
                aria-controls="navbar-user" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
        </div>
        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-user">
            <ul
                class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg text-white md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0">
                <li>
                    <a href="{{url('/')}}"
                        class="block py-2 px-3 text-white bg-red-700 rounded md:bg-transparent md:text-red-700 md:p-0 md:dark:text-red-500"
                        aria-current="page">Home</a>
                </li>
                <li>
                    <a href="{{route('token')}}"
                        class="block py-2 px-3 text-white rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-red-600 md:p-0 md:dark:hover:text-red-600 md:dark:hover:bg-transparent ">Token</a>
                </li>
                <li>
                    <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar"
                        class="flex items-center justify-between w-full py-2 px-3 text-white hover:bg-red-700 md:hover:bg-transparent md:border-0 md:hover:text-red-700 md:p-0 md:w-auto">Administrar
                        <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg></button>
                    <!-- Dropdown menu -->
                    <div id="dropdownNavbar"
                        class="z-10 hidden font-normal bg-gray-700 divide-y divide-gray-100 rounded-lg shadow w-44">
                        <ul class="py-2 text-sm text-white" aria-labelledby="dropdownLargeButton">
                            <li>
                                <a href="{{route('emisor')}}"
                                    class="block px-4 py-2 hover:bg-red-600">Emisores</a>
                            </li>
                            <li>
                                <a href="{{route('receptor')}}"
                                    class="block px-4 py-2 hover:bg-red-600">Receptores</a>
                            </li>
                            <li aria-labelledby="dropdownNavbarLink">
                                <button id="doubleDropdownButton" data-dropdown-toggle="doubleDropdown" data-dropdown-placement="right-start" type="button" class="flex items-center justify-between w-full px-4 py-2 hover:bg-red-700">Eventos<svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
              </svg></button>
                                <div id="doubleDropdown" class="z-10 hidden bg-gray-700 divide-y divide-gray-100 rounded-lg shadow w-44">
                                    <ul class="py-2 text-sm text-gray-700" aria-labelledby="doubleDropdownButton">
                                      <li>
                                        <a href="{{route('eContingencia')}}" class="block px-4 py-2 hover:bg-red-700 text-white">Contingencia</a>
                                      </li>
                                      <li>
                                        <a href="{{route('eInvalidacion')}}" class="block px-4 py-2 hover:bg-red-700 text-white">Invalidacion</a>
                                      </li>
                                    </ul>
                                </div>
                              </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="{{route('documento')}}"
                        class="block py-2 px-3 text-white rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-red-700 md:p-0 md:dark:hover:text-red-500 md:dark:hover:bg-transparent">Historial</a>
                </li>
                {{-- <li>
          <a href="#" class="block py-2 px-3 text-white rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-red-700 md:p-0 md:dark:hover:text-red-500 md:dark:hover:bg-transparent">Eventos</a>
        </li> --}}
                <li>
                    <a href="{{route('factura')}}"
                        class="block py-2 px-3 text-white rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-red-700 md:p-0 md:dark:hover:text-red-500 md:dark:hover:bg-transparent">DTE</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
