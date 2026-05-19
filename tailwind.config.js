/** @type {import('tailwindcss').Config} */

module.exports = {

  content: [

    "../*.php",
    "../user/*.php",
    "../admin/*.php",
    "../components/*.php",
    "../includes/*.php"

  ],

  theme: {

    extend: {

      colors: {

        tealPrimary: "#0F766E",
        tealLight: "#14B8A6",
        creamWhite: "#FDFCF8"

      }

    }

  },

  plugins: []

}