import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    DEFAULT: '#15803D',
                    50: '#f0fdf4',
                    100: '#dcfce7',
                    200: '#bbf7d0',
                    300: '#86efac',
                    400: '#4ade80',
                    500: '#22c55e',
                    600: '#16a34a',
                    700: '#15803d',
                    800: '#166534',
                    900: '#14532d',
                    950: '#052e16',
                },
                secondary: {
                    DEFAULT: '#D97706',
                    50: '#fffbeb',
                    100: '#fef3c7',
                    200: '#fde68a',
                    300: '#fcd34d',
                    400: '#fbbf24',
                    500: '#f59e0b',
                    600: '#d97706',
                    700: '#b45309',
                    800: '#92400e',
                    900: '#78350f',
                    950: '#451a03',
                },
                herbal: {
                    dark: '#022C22',
                    forest: '#14532D',
                    emerald: '#15803D',
                    sage: '#86EFAC',
                    cream: '#FAF9F5',
                    amber: '#D97706',
                    gold: '#F59E0B',
                },
                premium: {
                    gold: '#FFD700',
                    platinum: '#E5E4E2',
                    rose: '#FF007F',
                    sapphire: '#0F52BA',
                    emerald: '#10B981',
                    onyx: '#1f2937',
                    glass: 'rgba(255,255,255,0.15)',
                },
                gradient1: 'linear-gradient(135deg, #15803d 0%, #052e16 100%)',
                gradient2: 'linear-gradient(135deg, #86efac 0%, #16a34a 100%)',
            },
            boxShadow: {
                premium: '0 8px 32px 0 rgba(21, 128, 61, 0.2)',
                glass: '0 4px 30px rgba(0, 0, 0, 0.08)',
                gold: '0 2px 8px 0 rgba(217, 119, 6, 0.25)',
                herbal: '0 10px 40px -10px rgba(21, 128, 61, 0.3)',
            },
            backgroundImage: {
                'gradient-herbal': 'linear-gradient(135deg, #052e16 0%, #14532d 40%, #15803d 70%, #d97706 100%)',
                'gradient-gold': 'linear-gradient(90deg, #FFD700 0%, #FFB300 100%)',
                'gradient-rose': 'linear-gradient(90deg, #FF007F 0%, #FF8A00 100%)',
                'gradient-sapphire': 'linear-gradient(90deg, #0F52BA 0%, #43cea2 100%)',
                'glass': 'linear-gradient(135deg, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0.05) 100%)',
            },
            keyframes: {
                'fade-in': {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                'slide-up': {
                    '0%': { transform: 'translateY(40px)', opacity: '0' },
                    '100%': { transform: 'translateY(0)', opacity: '1' },
                },
                'glass-float': {
                    '0%, 100%': { filter: 'blur(0px)' },
                    '50%': { filter: 'blur(2px)' },
                },
            },
            animation: {
                'fade-in': 'fade-in 0.8s ease-out',
                'slide-up': 'slide-up 0.7s cubic-bezier(0.4,0,0.2,1)',
                'glass-float': 'glass-float 3s ease-in-out infinite',
            },
            typography: {
                DEFAULT: {
                    css: {
                        color: '#353839',
                        h1: { fontWeight: '800', fontSize: '2.5rem', letterSpacing: '-.02em' },
                        h2: { fontWeight: '700', fontSize: '2rem' },
                        h3: { fontWeight: '600', fontSize: '1.5rem' },
                        h4: { fontWeight: '600', fontSize: '1.25rem' },
                        p: { fontSize: '1.1rem', lineHeight: '1.7' },
                    },
                },
            },
            spacing: {
                'xs': '0.5rem',
                'sm': '1rem',
                'md': '2rem',
                'lg': '3rem',
                'xl': '4rem',
                '2xl': '6rem',
            },
        },
    },

    plugins: [forms],
};
