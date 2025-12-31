import preset from './vendor/filament/support/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './resources/views/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
    theme: {
        extend: {
            colors: {
                'kots': {
                    'primary': '#1B7B9E',
                    'secondary': '#2BA3C8',
                    'accent': '#4DBFE8',
                    'light': '#E8F5F9',
                    'dark': '#0D3B52',
                },
                'ngekos': {
                    'grey': '#8B8B8B',
                    'orange': '#FF9500',
                }
            },
        },
    },
}