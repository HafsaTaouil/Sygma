<div class="h-full flex justify-end mx-12 items-center">
    <div class="h-max w-72">
        <div class="bg-[#008080] bg-opacity-75 rounded-lg">
            <div class="flex flex-col h-[402px] items-center justify-between px-4 py-2">
                <div class="flex flex-col items-center">
                    <img src="{{ asset('images/SygmaLogo2.png') }}" alt="Sygma Logo">
                    <form id="login-form" method="POST" action="{{ route('login') }}" class="bg-[#00A1A1] p-4 flex flex-col gap-2 rounded-lg w-full">
                        @csrf

                        <!-- Email -->
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-envelope text-white"></i>
                            <input class="z-50 outline-none w-full rounded-lg p-2" type="text" name="email" placeholder="Votre Email...">
                        </div>
                        @error('email')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror

                        <!-- Password -->
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-lock text-white"></i>
                            <input class="z-50 outline-none w-full rounded-lg p-2" type="password" name="password" placeholder="Mot de passe...">
                        </div>
                        @error('password')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror

                        <!-- Remember Me -->
                        <div class="flex items-center justify-between mt-2">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Se souvenir de moi ') }}</span>
                            </label>
                        </div>

                        <!-- Forgot Password -->
                        @if (Route::has('password.request'))
                            <a class="mt-2 bg-transparent underline text-white text-sm" href="{{ route('password.request') }}">
                                {{ __('Mot de passe oublié?') }}
                            </a>
                        @endif
                    </form>
                </div>
                <button type="submit" form="login-form" class="z-50 mb-4 font-bold bg-[#00A1A1] px-8 py-2 text-white rounded-lg text-xl">Se connecter</button>
            </div>
        </div>
    </div>
</div>
<div class="flex justify-end items-end h-full w-full fixed top-0 z-5">
    <div class="w-full h-fit bg-[#008080]">
        <div class="flex justify-between px-4 py-2 items-center">
            <p class="text-md text-white">© Copyright SYGMA.AI 2024</p>
            <img src="{{ asset('images/SygmaLogo.png') }}" class="w-1/12" alt="Sygma Logo">
        </div>
    </div>
</div>
