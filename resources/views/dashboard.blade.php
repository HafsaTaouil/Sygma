<x-app-layout>

    <head>
        <!-- font-family: "Comfortaa", sans-serif;-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&display=swap" rel="stylesheet">
        <!---->
    </head>

    <div id="container">
        <div class="p-4 flex gap-2 flex-col">
            <div class="flex flex-row justify-end">
                <h1 class="text-2xl font-bold border-b-2 border-[#009999] pb-2" style="font-family: 'Comfortaa', sans-serif;">Welcome to your dashboard, {{ Auth::user()->username }}!</h1>
                <div class="relative ml-2">
                    <img class="w-10 h-10 rounded-full cursor-pointer border border-[#009999]" src="{{asset('images/user.png')}}" alt="">
                    <span class="bottom-0 left-7 absolute  w-3.5 h-3.5 bg-green-400 border-1 border-white dark:border-gray-500 rounded-full"></span>
                </div>
            </div>      
        </div>

        {{-- <p class="">Access a summary of all your car damage reports and the associated details in your account.</p> --}}

    </div>

    

</x-app-layout>
