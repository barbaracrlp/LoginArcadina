<?php
namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\Component;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
//ahora la importacion del login

use Filament\Pages\Auth\Login as BaseLogin;

class Auth extends BaseLogin
{
    /**puedo hacer el formulario de primeras ya, pero le tendre que devolver bien la data */

    public function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('mail')
            ->label("Usuario")
            ->required()
            ->maxLength(255)
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1]),
            $this->getPasswordFormComponent()
        ]);
    }

    public function getPasswordFormComponent():Component
    {
       return TextInput::make('pass')
       ->label("Contraseña")
            ->required()
            ->password()
            ->extraInputAttributes(['tabindex' => 2]);
            
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'mail' => $data['email'],
            'pass' => $data['password'],
        ];
    }

}





?>