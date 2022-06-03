module.exports = {
  content: ["./src/**/*.{html,js}",
            "./*.php"],
  theme: {
    extend: {},
    container: {
      center: true,
    }
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}