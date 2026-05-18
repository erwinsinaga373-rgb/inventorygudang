<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    {{-- Brand Row --}}
    <div class="flex items-center gap-3 mb-6">
        <div class="w-10 h-10 rounded-xl flex-shrink-0" style="background:#607964; display:flex; align-items:center; justify-content:center; box-shadow: 0 4px 12px rgba(96, 121, 100, 0.2);">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" style="color:#fff;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c-4.97 0-9 4.03-9 9s4.03 9 9 9 9-4.03 9-9-4.03-9-9-9zm0 0c0 4.97-2.686 9-6 9m6-9c0 4.97 2.686 9 6 9M3 12h18" />
            </svg>
        </div>
        <div>
            <p class="text-sm font-bold leading-tight" style="color:#2C382E;">UD. Karya Sejahtera</p>
            <p class="text-xs leading-tight" style="color:#849E88;">Sistem Informasi Inventory</p>
        </div>
    </div>

    <hr class="mb-6" style="border-color:#A9BFA3; opacity: 0.3;" />

    {{-- Secure badge --}}
    <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full mb-5" style="background:#F4F7F4; color:#607964;">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
        </svg>
        Secure Login
    </span>

    <h1 class="text-xl font-bold mb-1" style="color:#2C382E; letter-spacing:-0.02em;">Selamat Datang</h1>
    <p class="text-sm mb-6" style="color:#607964;">Silahkan masuk untuk mengakses workspace Anda</p>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        {{-- Email --}}
        <div>
            <label for="email" class="block text-xs font-bold uppercase tracking-widest mb-1.5" style="color:#607964;">
                {{ __('Email address') }}
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" style="color:#849E88;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                    </svg>
                </div>
                <input
                    id="email" name="email" type="email"
                    value="{{ old('email') }}"
                    placeholder="nama@email.com"
                    required autofocus autocomplete="username"
                    class="block w-full pl-9 pr-3 h-11 text-sm rounded-xl border transition-all duration-150 focus:outline-none"
                    style="border-color:#A9BFA3; background:#F4F7F4; color:#2C382E;"
                    onfocus="this.style.borderColor='#607964';this.style.background='#fff';this.style.boxShadow='0 0 0 3px rgba(96,121,100,0.15)'"
                    onblur="this.style.borderColor='#A9BFA3';this.style.background='#F4F7F4';this.style.boxShadow='none'"
                />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="block text-xs font-bold uppercase tracking-widest mb-1.5" style="color:#607964;">
                {{ __('Password') }}
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" style="color:#849E88;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                </div>
                <input
                    id="password" name="password" type="password"
                    placeholder="••••••••"
                    required autocomplete="current-password"
                    class="block w-full pl-9 pr-3 h-11 text-sm rounded-xl border transition-all duration-150 focus:outline-none"
                    style="border-color:#A9BFA3; background:#F4F7F4; color:#2C382E;"
                    onfocus="this.style.borderColor='#607964';this.style.background='#fff';this.style.boxShadow='0 0 0 3px rgba(96,121,100,0.15)'"
                    onblur="this.style.borderColor='#A9BFA3';this.style.background='#F4F7F4';this.style.boxShadow='none'"
                />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        {{-- Remember & Forgot --}}
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer">
                <input
                    id="remember_me" type="checkbox" name="remember"
                    class="rounded border-gray-300 shadow-sm"
                    style="accent-color:#607964; width:14px; height:14px;"
                />
                <span class="text-sm" style="color:#607964;">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm font-medium hover:underline transition-colors" style="color:#607964;">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        {{-- Submit --}}
        <div class="pt-1">
            <button
                type="submit"
                class="w-full h-11 flex items-center justify-center gap-2 text-sm font-semibold text-white rounded-xl transition-all duration-150 active:scale-[0.98] focus:outline-none"
                style="background: linear-gradient(135deg, #738B73 0%, #4A5D4E 100%); box-shadow: 0 4px 15px rgba(74, 93, 78, 0.2);"
                onmouseover="this.style.opacity='0.95'; 本.style.transform='translateY(-1px)'"
                onmouseout="this.style.opacity='1'; this.style.transform='none'"
            >
                {{ __('Sign in') }}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                </svg>
            </button>
        </div>
    </form>

    {{-- Footer --}}
    <div class="mt-5 pt-5 flex items-center justify-center gap-3 text-xs" style="border-top:0.5px solid #A9BFA3; color:#849E88; opacity: 0.8;">
        <span class="flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" style="color:#607964;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
            </svg>
            256-bit SSL Secure
        </span>
        <span style="width:4px;height:4px;background:#607964;border-radius:50%;opacity:0.3;display:inline-block;"></span>
        <span>&copy; {{ date('Y') }} UD. Karya Sejahtera</span>
    </div>

</x-guest-layout>