<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Component;
use Filament\Pages\Auth\Login as BaseAuth;
use Illuminate\Validation\ValidationException;

//la clase nueva extiende la original
class LoginEdit extends BaseAuth
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
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->autocomplete('current-password')
            ->required()
            ->extraInputAttributes(['tabindex' => 2]);
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        error_log('saca las credenciales del formulario');
        return [
            'mail' => $data['mail'],
            'pass' => $data['pass'],
        ];
    }


    //añado el manejo de errores a ver si es por eso
    protected function throwFailureValidationException(): never
    {
        error_log('envia error algo falla pero si hace algo');
        throw ValidationException::withMessages([
            'data.login' => __('filament-panels::pages/auth/login.messages.failed'),
            'data.mail' => __('filament-panels::pages/auth/login.messages.failed'),
            'data.pass' => __('filament-panels::pages/auth/login.messages.failed'),
        ]);
    }



}
