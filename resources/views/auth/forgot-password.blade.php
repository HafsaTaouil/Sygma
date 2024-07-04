<x-guest-layout>
    
    <!-- Session Status -->
    <x-auth-session-status class="mb-4 bg-white rounded-lg p-4" :status="session('status')" />

    <x-custom-forgot-pwd-form />

</x-guest-layout>
