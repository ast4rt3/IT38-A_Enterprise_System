import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
    extend: {
      colors: {
        brand: '#895353', // Add your brand color
      },
      fontFamily: {
        sans: ['Figtree', 'sans-serif'], // Use the Figtree font
      },
    },
  },

    plugins: [forms],
};
