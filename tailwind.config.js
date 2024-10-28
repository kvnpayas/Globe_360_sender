/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        primary: '#0F3D5C',
        secondary: '#E76727',
        accent: '#57575B',
        light: '#D9D9D9',
      },
    },
  },
  plugins: [],
}

