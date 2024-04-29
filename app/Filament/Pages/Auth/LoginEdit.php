<?php

namespace App\Filament\Pages\Auth;

use App\Models\Usuario;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Component;
use Filament\Pages\Auth\Login as BaseAuth;
use Illuminate\Validation\ValidationException;

//importaciones para sobreescribir la autentificacion del login
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

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

    //vamos a intentar reescribir todo el metodo de autentificacion de Filament para ver si nos deja entrar con la contraseña que le damos
    //hace falta implementar el metodo check y validate de la contraseña origina de arcadina

    public function authenticate(): ?LoginResponse
{
    try {
        $this->rateLimit(5);
    } catch (TooManyRequestsException $exception) {
        // Handle rate limiting exception
        return null;
    }

    $data = $this->form->getState();

    // aqui esta la info que se introduce en el formulario 

    $email = $data['mail'];
    $password=$data['pass'];
    error_log('email es '.$email);
    error_log('password es '.$password);



    // Retrieve the user record from the database based on the email
    $user = Usuario::where('mail', $email)->first();

    $contraseña=$user->pass;
    error_log('contraseña del usuario '.$contraseña);

    //llamada a la funcion de la contraseña

    //aqui necesito tener en una variable la contraseña del usuario 


    // If the user doesn't exist or the password doesn't match, throw a validation exception
    if (!$user || !password_verify($data['password'], $user->password)) {
        $this->throwFailureValidationException();
    }

    // Optionally, you can perform additional checks or actions here if needed

    // If authentication is successful, regenerate the session
    session()->regenerate();

    return app(LoginResponse::class);
}


}
