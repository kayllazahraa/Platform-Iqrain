/** @type {import('tailwindcss').Config} */
const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./app/Http/Livewire/**/*.php",
    ],

    theme: {
    extend: {
        fontFamily: {
            sans: ["Mooli", ...defaultTheme.fontFamily.sans],
            titan: ['Titan One', 'cursive'],                                            
            tegak: ['"Tegak Bersambung_IWK"', 'cursive'],                         
            'cursive-iwk': ['"Tegak Bersambung_IWK"', 'cursive'],
        }        
    },
},
plugins: [],
}
