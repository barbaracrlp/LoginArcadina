import preset from '../../../../vendor/filament/filament/tailwind.config.preset'
import colors from 'tailwindcss/colors' 
import forms from '@tailwindcss/forms'
import typography from '@tailwindcss/typography' 

export default {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
    theme: {
        colors: {
            // Define your custom colors directly
            // danger: colors.rose,
            // primary: colors.blue,
            // success: colors.green,
            // warning: colors.yellow,
            // Add more custom colors as needed
            /**aqui procedo a fefinir los colores */
            primary:{
                //el color azul arcadina
                50: '#E1F5FB',
                100: '#B4E6F5',
                200: '#85D5EF',
                300: '#59C4E9',
                400: '#3AB7E6',
                500: '#21ABE3',
                600: '#1A9DD5',
                700: '#108AC2',
                800: '#0F79AE',
                900: '#045A8D',
                950: '#2A2466',
        
            },
            success: {
                //el color azul arcadina
                50: '#ECFDF5',
                100: '#D1FAE5',
                200: '#A7F3DO',
                300: '#6EE7B8',
                400: '#33D39A',
                500: '#10B981',
                600: '#05966A',
                700: '#047857',
                800: '#065F46',
                900: '#064E3B',
                950: '#024231',
            },
            warning: {
                //el color naranja
                50: '#FFF7ED',
                100: '#FFEDD5',
                200: '#FED7AA',
                300: '#FDBB74',
                400: '#FB923C',
                500: '#f97316',
                600: '#ea580d',
                700: '#c2410c',
                800: '#9a3412',
                900: '#7c2e11',
                950: '#662109',
            },
            info:{
                //el color azul arcadina  en teoria
                50: '#E1F5FB',
                100: '#B4E6F5',
                200: '#85D5EF',
                300: '#59C4E9',
                400: '#3AB7E6',
                500: '#21ABE3',
                600: '#1A9DD5',
                700: '#108AC2',
                800: '#0F79AE',
                900: '#045A8D',
                950: '#2A2466',
            },
            danger:{
                //el color rojo
                50: '#FEF2F2',
                100: '#FEE2E2',
                200: '#FECACA',
                300: '#FCA4A5',
                400: '#F87170',
                500: '#EF4444',
                600: '#DC2626',
                700: '#B91C1C',
                800: '#991B1B',
                900: '#7F1D1D',
                950: '#6B1011',
            },
            neutral:{
                     //el color NEUTRAL
                     50: '#F9FAFB',
                     100: '#F3F4F6',
                     200: '#E5E7EA',
                     300: '#D1D5DB',
                     400: '#9CA3AF',
                     500: '#6B7280',
                     600: '#4B5563',
                     700: '#374151',
                     800: '#1F2937',
                     900: '#111827',
                     950: '#04070C',
            }

        }, 
    },
    plugins: [
        forms, 
        typography, 
    ],
}
