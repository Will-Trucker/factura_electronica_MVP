@extends('layouts.app')
@section('content')

@if (session('error'))
            <div class="mb-4 text-red-500">
                {{ session('error') }}
            </div>
        @endif

<section class="" style=" background: #1b1f22;">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-white dark:text-white">
            <img class="w-8 h-8 mr-2" src="{{ Vite::asset('resources/img/factura.png') }}" alt="logo"> | MVP Facturador
        </a>
        <div class="w-full rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 " style=" background: #37393a;">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                   Bienvenido
                </h1>
                <form class="space-y-4 md:space-y-6" action="{{route('login')}}" method="POST">
                    @csrf
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" required=""  style=" background: #171718;">
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                        <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="" style=" background: #171718;text-transform:none;">
                    </div>

                    <button type="submit" class="w-full focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Ingresar</button>
                </form>
            </div>
        </div>
    </div>
  </section>
@endsection
