<div class="h-full flex justify-end mx-12 items-center">
    <div class="h-max w-72">
        <div class="bg-[#008080] bg-opacity-75 rounded-lg">
            <div class="flex flex-col h-[402px] items-center justify-between px-4 py-2">
                <div class="flex flex-col items-center">
                    <img src="{{ asset('images/SygmaLogo2.png') }}" alt="Sygma Logo">

                    <div class="mb-4 text-sm text-white">
                        {{ __('Forgot your password?  No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                    </div>

                    <form id="send-form" method="POST" action="{{ route('password.email') }}" class="bg-[#00A1A1] p-4 flex flex-col gap-2 rounded-lg w-full">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-envelope text-white"></i>
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" placeholder="Votre Email..." :value="old('email')" required autofocus />
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                    
                    </form>

                    <button type="submit" form="send-form" class="z-50 mb-4  mt-10 font-bold bg-[#00A1A1] px-8 py-2 text-white rounded-lg text-xl">Envoyer</button>


                </div>
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