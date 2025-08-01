import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.blade.php',
  ],
  darkMode: 'class',
  theme: {
    extend: {
      fontFamily: {
        'inter': [
          'Figtree',
          ...defaultTheme.fontFamily.sans,
        ],
      },
    },
  },
  plugins: [],
}
