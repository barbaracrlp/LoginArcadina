<?php

namespace App\Filament\Pages\Auth;

use App\Models\Usuario;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Component;
use Filament\Pages\Auth\Login as BaseAuth;
use Illuminate\Validation\ValidationException;

use Filament\Facades\Filament;
use Filament\Models\Contracts\FilamentUser;
use Filament\Notifications\Notification;

//importaciones para sobreescribir la autentificacion del login
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

//la clase nueva extiende la original
class LoginEdit extends BaseAuth
{

    //añado la nueva vista 
    /**de momento quito la vista para ver si sirve el renderHook */
    // protected static string $view = 'viewLogin2';

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
            Notification::make()
            ->title(__('filament-panels::pages/auth/login.notifications.throttled.title', [
                'seconds' => $exception->secondsUntilAvailable,
                'minutes' => ceil($exception->secondsUntilAvailable / 60),
            ]))
            ->body(array_key_exists('body', __('filament-panels::pages/auth/login.notifications.throttled') ?: []) ? __('filament-panels::pages/auth/login.notifications.throttled.body', [
                'seconds' => $exception->secondsUntilAvailable,
                'minutes' => ceil($exception->secondsUntilAvailable / 60),
            ]) : null)
            ->danger()
            ->send();

            return null;
        }

        $data = $this->form->getState();

        // aqui esta la info que se introduce en el formulario 

        $email = $data['mail'];
        $password = $data['pass'];
        // error_log('email es ' . $email);
        // error_log('password es ' . $password);



        // Retrieve the user record from the database based on the email
        $user = Usuario::where('mail', $email)->first();

        $contraseña = $user->pass;
        // error_log('contraseña del usuario ' . $contraseña);

        //llamada a la funcion de la contraseña

        //aqui necesito tener en una variable la contraseña del usuario 


        // If the user doesn't exist or the password doesn't match, throw a validation exception

        //creo primero la funcion y luego lo que hago es cambiar el nombre en esta condicion de aqui luego
        if (!$user || !self::verificaContraseña($contraseña, $password)) {
            $this->throwFailureValidationException();
        }

        
        // Optionally, you can perform additional checks or actions here if needed
        if (
            ($user instanceof FilamentUser) &&
            (! $user->canAccessPanel(Filament::getCurrentPanel()))
        )
        {
            Notification::make()
            ->title('Acceso denegado')
            ->danger()
            ->icon('heroicon-o-document-heroicon-o-document-text') 
            ->send();
            Filament::auth()->logout();
            error_log('no entra por el acceso');
        
            $this->throwFailureValidationException();
        }

        $usuario = Filament::auth()->login($user,false);
        // If authentication is successful, regenerate the session
        session()->regenerate();

        return app(LoginResponse::class);
    }

    /**a partir de aqui la verificacion de las contraseñas
     * tengo en una variable $data[pass]
     * en la otra tengo $user->pass 
     */
    const METHOD = PASSWORD_BCRYPT;
    public function verificaContraseña($pass_db, $pass_login): bool
    {

        //asi es el original pero lo convierto en constante
        //const METHOD = PASSWORD_BCRYPT;
        error_log('verifico quese creo como toca ');
        if (!self::check($pass_db)) {
            return FALSE;
        }

        // Quitamos la marca
        $pass_db = substr($pass_db, 5);

        // Descodificamos de base64
        $pass_db = base64_decode($pass_db);

        //aqui en teoria se verifica si es o no a contraseña que toca
        error_log('la verificacion devolveria: ' . password_verify($pass_login, $pass_db));
        return password_verify($pass_login, $pass_db);
    }

    /**otra funcion la llamada check en el original */
    public static function check($hash)
    {

        error_log('llama al check con el hash');
        $ret = mb_substr($hash, 0, 5) === 'hash:';
        if ($ret) {
            // Verificamos que la cadena ha sido cifrada con el METHOD
            $hashInfo = password_get_info(base64_decode(mb_substr($hash, 5)));
            $ret = $hashInfo['algo'] == self::METHOD;
        }
        return $ret;
    }
}
