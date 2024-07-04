@props(['token', 'email'])


<div class="h-full flex justify-end mx-12 items-center">
    <div class="h-max w-72">
        <div class="bg-[#008080] bg-opacity-75 rounded-lg">
            <div class="flex flex-col h-[402px] items-center justify-between px-4 py-2">
                <div class="flex flex-col items-center">
                    <img src="{{ asset('images/SygmaLogo2.png') }}" alt="Sygma Logo">

                    <form id="reset-form" method="POST" action="{{ route('password.store') }}" class="bg-[#00A1A1] p-4 flex flex-col gap-2 rounded-lg w-full">
                        @csrf

                        <!-- Password Reset Token -->
                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="email" value="{{ $email }}">


                        <!-- Email Address -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="$email" readonly required autofocus autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                         </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Confirm Password -->
                        <div class="mt-4">
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                                type="password"
                                                name="password_confirmation" required autocomplete="new-password" />

                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                    </form>

                    </div>
                <button form="reset-form" type="submit" form="login-form" class="z-50 mb-4 mt-4 font-bold bg-[#00A1A1] px-8 py-2 text-white rounded-lg text-xl">Se connecter</button>
            </div>
        </div>
    </div>
</div>
<!--footer--
<div class="flex justify-end items-end h-full w-full fixed top-0 z-5">
    <div class="w-full h-fit bg-[#008080]">
        <div class="flex justify-between px-4 py-2 items-center">
            <p class="text-md text-white">© Copyright SYGMA.AI 2024</p>
            <img src="{{ asset('images/SygmaLogo.png') }}" class="w-1/12" alt="Sygma Logo">
        </div>
    </div>
</div>
