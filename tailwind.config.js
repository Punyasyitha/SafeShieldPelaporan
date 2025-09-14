// tailwind.config.cjs
const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
  darkMode: 'class',
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
    './public/**/*.html',
    './node_modules/flowbite/**/*.js',
  ],
  theme: {
    extend: {
      fontFamily: { sans: ['Figtree', ...defaultTheme.fontFamily.sans] },

      keyframes: {
        ripple: {
          '0%':   { transform: 'translate(-50%, -50%) scale(0.9)', opacity: '0.55' },
          '70%':  { transform: 'translate(-50%, -50%) scale(1.25)', opacity: '0' },
          '100%': { opacity: '0' },
        },
        float: {
          '0%,100%': { transform: 'translateY(0)' },
          '50%':     { transform: 'translateY(-6px)' },
        },
        slowspin: {
          '0%':   { transform: 'rotate(0deg)' },
          '100%': { transform: 'rotate(360deg)' },
        },
      },

      animation: {
        ripple:     'ripple 3.2s ease-out infinite',
        'ripple-2': 'ripple 3.2s ease-out 1.2s infinite',
        float:      'float 6s ease-in-out infinite',
        'spin-slow':'slowspin 20s linear infinite',
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('flowbite/plugin'),
    require('tailwind-scrollbar-hide'),
  ],
}
