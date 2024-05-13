<x-filament-panels::page.simple>
    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::BODY_START) }}
    @include('extra_login_head')
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

{{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::BODY_END) }}
@include('extra_login_foot')
</x-filament-panels::page.simple> 