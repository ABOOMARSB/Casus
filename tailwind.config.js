module.exports = {
  content: ["./templates/**/*.html.twig"],
  darkMode: true, // or 'media' or 'class'
  theme: {
    fontFamily: {
      "roboto": ["Maven Pro", "sans-serif"],
      "importBtn": ["permanent Marker", "cursive"],
    },
    extend: {
      shadows: {

      },
      colors: {
        primary: '#0081E9',
        red: '#c42324',
        grey: '#7C7C7C',
        lightGrey: '#9F9F9F',
        newToday: '#0081E9',
        green: '#40BF4B',
        darkGreen: '#447d49',
        darkBlue: '#00AEEA',
        lightBlue: '#77BBFF',
        LighterBlue: '#66B3F2',
        smallNav: '#99CDF6',
        lightBlack: '#000000C4',
        wheat: '#F5DEB3FF',
        lightWheat: '#FFFFCE',
        darkGrey: '#7e7474',

      },
      borderRadius: {
        '5xxl': '110px',
      },
    },
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
