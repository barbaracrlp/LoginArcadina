<?php
namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\Component;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
//ahora la importacion del login

use Filament\Pages\Auth\Login as BaseLogin;

class Auth extends BaseLogin
{

    /**Agrego el nuevo metodo de autentificacion  */
    /**puedo hacer el formulario de primeras ya, pero le tendre que devolver bien la data */

    public function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('email')
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
       return TextInput::make('password')
       ->label("Contraseña")
            ->required()
            ->password()
            ->extraInputAttributes(['tabindex' => 2]);
            
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'email' => $data['mail'],
            'password' => $data['pass'],
        ];
    }



}





?>