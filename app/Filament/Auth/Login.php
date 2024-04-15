<?php
namespace App\Filament\Auth;

use Filament\Pages\Auth\Login as BaseAuth;
//importo las cosas

use Filament\Forms\Components\TextInput;
use Filament\forms\Components\Component;
use Filament\Forms\Form;

class Login extends BaseAuth{

    public function form(Form $form): Form
    {
        return $form
        ->schema([
            $this->getEmailFormComponent(),
            $this->getPasswordFormComponent()
        ])->statePath('data');
    }

    //ahora sobreescribo las funciones del login original
     protected function getEmailFormComponent(): Component
     {
        return TextInput::make('mail')
        ->label('Email')
        ->email()
        ->required()
        ->autofocus()
        ->extraInputAttributes(['tabindex'=>1]);
     }

     protected function getPasswordFormComponent(): Component
     {
        return TextInput::make('pass')
        ->label('Contraseña')
        ->required()
        ->extraInputAttributes(['tabindex'=>2]);
     }

     //la de como recibir los dtos
     protected function getCredentialsFromFormData(array $data): array
     {
        return [
            'mail'=>$data['mail'],
            'pass'=>$data['pass'],
        ];
     }


}



?>