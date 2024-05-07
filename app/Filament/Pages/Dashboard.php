<?php
 
namespace App\Filament\Pages;
 
class Dashboard extends \Filament\Pages\Dashboard
{
    // ...

    protected static ?string $navigationLabel = 'Home My hogar';
    protected static ?string $title = 'Home';

    protected static ?string $navigationIcon = 'fas-house';
}