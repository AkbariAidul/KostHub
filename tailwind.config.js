import preset from './vendor/filament/support/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
    theme: {
        extend: {
            // --- INI RAHASIANYA ---
            // Kita override border radius bawaan Filament agar lebih "bulat" ala BWA
            borderRadius: {
                'none': '0',
                'sm': '0.375rem',  // 6px
                DEFAULT: '0.75rem', // 12px (Standar baru kita)
                'md': '0.75rem',    // 12px
                'lg': '1.0rem',     // 16px (Untuk Card)
                'xl': '1.5rem',     // 24px (Untuk Modal/Dialog)
                '2xl': '2rem',      // 32px
            },
        },
    },
}