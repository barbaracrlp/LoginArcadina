{{-- nueva pagina del login para añadir la foto

<x-filament-panels::page.simple>
    @if (filament()->hasRegistration())
    <x-slot name="subheading">
        {{ __('filament-panels::pages/auth/login.actions.register.before') }}

        {{ $this->registerAction }}
    </x-slot>
    @endif

    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE,
    scopes: $this->getRenderHookScopes()) }}

    <x-filament-panels::form wire:submit="authenticate">
        {{ $this->form }}

        <x-filament-panels::form.actions :actions="$this->getCachedFormActions()"
            :full-width="$this->hasFullWidthFormActions()" />
    </x-filament-panels::form>

    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_AFTER,
    scopes: $this->getRenderHookScopes()) }}
</x-filament-panels::page.simple> --}}


@props([
    'heading' => null,
    'logo' => true,
    'subheading' => null,
])

<style>
    .fi-simple-main{
   
        margin: 0%;
        
        max-width: 80%;
    }
    /* section{
        display: flex;
    } */
   /*tengo que encontrar el div principal y poner los dos
    /* .sm\:max-w-lg {
        max-width: 80%;
    } */
    /* .bg-white{
        background-color: blueviolet !important;
    }
    main{
        background-color: blueviolet;
    } */
</style>

<div class="flex">
    <div class="flex-1 flex flex-col items-center">
        <header class="fi-simple-header flex flex-col items-center">
            @if ($logo)
                <x-filament-panels::logo class="mb-4" />
            @endif
        
           
                <h1
                    class="fi-simple-header-heading text-center text-2xl font-bold tracking-tight text-gray-950 dark:text-white"
                >
                    Inicia Sesión
                </h1>
        
        
          
                <p
                    class="fi-simple-header-subheading mt-2 text-center text-sm text-gray-500 dark:text-gray-400"
                >
                   Bienvenido de nuevo!
                </p>
           
        </header>
        @if (filament()->hasRegistration())
        <x-slot name="subheading">
            {{ __('filament-panels::pages/auth/login.actions.register.before') }}

            {{ $this->registerAction }}
        </x-slot>
        @endif

        {{
        \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE,
        scopes: $this->getRenderHookScopes()) }}
  
  
        <x-filament-panels::form wire:submit="authenticate">
            {{ $this->form }}

            <x-filament-panels::form.actions :actions="$this->getCachedFormActions()"
                :full-width="$this->hasFullWidthFormActions()" />
        </x-filament-panels::form>

        {{
        \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_AFTER,
        scopes: $this->getRenderHookScopes()) }}
    </div>
   
    <div class='flex-1 flex flex-col'>
        <img src="/images/fotoLogin.jpg" alt="Image" class="w-full h-auto">
    </div>
</div>


