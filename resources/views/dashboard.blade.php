<x-app-layout>
    <!--
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> 
-->

    <div class="p-4 flex gap-2 flex-col">
        <div class="flex justify-end">
            <h1 class="text-2xl font-bold">Bienvenue dans ton tableau de bord, {{ Auth::user()->username }}!</h1>
        </div>
    </div>
</x-app-layout>
