export default defineNuxtConfig({
  modules: [
    'shadcn-nuxt',
    '@nuxtjs/tailwindcss'
  ],

  shadcn: {
    
    prefix: '',
    /**
     * Directory that the components live in.
     * @default "./components/ui"
     */
    componentDir: './components/ui'
  },

  devtools: { enabled: true },
  css: ['~/assets/css/tailwind.css'],
  compatibilityDate: '2025-04-21',
})