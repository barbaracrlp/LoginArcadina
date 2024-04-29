<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;

use Filament\Forms\Components\Component;


//el login nou ha de extendre el original
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;

//la clase nueva extiende la original
class LoginEdit extends BaseLogin
{

//el nuevo formulario
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getEmailFormComponent(),  
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),
            ])
            ->statePath('data');
    }

    //cambio los nombres de los inputs
    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('mail')
            ->label(__('filament-panels::pages/auth/login.form.email.label'))
            ->email()
            ->required()
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1]);
    } 

    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('pass')
            ->label(__('filament-panels::pages/auth/login.form.password.label'))
            ->hint(filament()->hasPasswordReset() ? new HtmlString(Blade::render('<x-filament::link :href="filament()->getRequestPasswordResetUrl()"> {{ __(\'filament-panels::pages/auth/login.actions.request_password_reset.label\') }}</x-filament::link>')) : null)
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->autocomplete('current-password')
            ->required()
            ->extraInputAttributes(['tabindex' => 2]);
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'mail' => $data['mail'],
            'pass' => $data['pass'],
        ];
    }




}
