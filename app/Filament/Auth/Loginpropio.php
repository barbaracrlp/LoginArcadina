<?php

namespace App\Filament\Auth\Loginpropio;


use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Component;
use Filament\Pages\Auth\Login as BaseAuth;
 
class Login extends BaseAuth
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getEmailFormComponent(), 
                $this->getPasswordFormComponent(),
            ])
            ->statePath('data');
    }
 
  

    protected function getemailFormComponent(): Component 
    {
        return TextInput::make('mail')
            ->label('Email')
            ->required()
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1]);
    }

    protected function getPasswordFormComponent(): Component 
    {
        return TextInput::make('pass')
            ->label('Password')
            ->required()
            ->autocomplete()
            ->extraInputAttributes(['tabindex' => 2]);
    } 


}
?>