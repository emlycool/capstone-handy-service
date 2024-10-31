export default {
  // Disable server-side rendering: https://go.nuxtjs.dev/ssr-mode
  ssr: false,
  target: 'static',

  // Global page headers: https://go.nuxtjs.dev/config-head
  head: {
    title: 'frontend',
    htmlAttrs: {
      lang: 'en'
    },
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: '' },
      { name: 'format-detection', content: 'telephone=no' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
      { rel: 'stylesheet', type: 'text/css', href: '/assets/css/all.min.css' },
      { rel: 'stylesheet', type: 'text/css', href: '/assets/css/bootstrap.min.css' },
      { rel: 'stylesheet', type: 'text/css', href: '/assets/css/venobox.min.css' },
      { rel: 'stylesheet', type: 'text/css', href: '/assets/css/slick.css' },
      { rel: 'stylesheet', type: 'text/css', href: '/assets/css/scroll_button.css' },
      { rel: 'stylesheet', type: 'text/css', href: '/assets/css/custom_spacing.css' },
      { rel: 'stylesheet', type: 'text/css', href: '/assets/css/select2.min.css' },
      { rel: 'stylesheet', type: 'text/css', href: '/assets/css/animate.css' },
      { rel: 'stylesheet', type: 'text/css', href: '/assets/css/nice-select.css' },
      { rel: 'stylesheet', type: 'text/css', href: '/assets/css/range_slider.css' },
      { rel: 'stylesheet', type: 'text/css', href: '/assets/css/jQuery-plugin-progressbar.css' },
      // { rel: 'stylesheet', type: 'text/css', href: '/assets/css/pointer.css' },
      { rel: 'stylesheet', type: 'text/css', href: '/assets/css/style.css' },
      { rel: 'stylesheet', type: 'text/css', href: '/assets/css/responsive.css' }
    ],
    script: [
      // jquery library js
      { src: '/assets/js/jquery-3.7.1.min.js' },
      // bootstrap js
      { src: '/assets/js/bootstrap.bundle.min.js' },
      // font-awesome js
      // { src: '/assets/js/Font-Awesome.js' },
      // // venobox js
      // { src: '/assets/js/venobox.min.js' },
      // // slick js
      // { src: '/assets/js/slick.min.js' },
      // counterup js
      // { src: '/assets/js/jquery.waypoints.min.js' },
      // { src: '/assets/js/jquery.countup.min.js' },
      // // scroll button js
      // { src: '/assets/js/scroll_button.js' },
      // // select 2 js
      // { src: '/assets/js/select2.min.js' },
      // // sticky sidebar js
      // { src: '/assets/js/sticky_sidebar.js' },
      // // wow js
      // { src: '/assets/js/wow.min.js' },
      // // range slider js
      // { src: '/assets/js/range_slider.js' },
      // // nice select js
      // { src: '/assets/js/jquery.nice-select.min.js' },
      // // marquee animi js
      // { src: '/assets/js/jquery.marquee.min.js' },
      // progressbar js
      // { src: '/assets/js/jQuery-plugin-progressbar.js' },
      // pointer js
      // { src: '/assets/js/pointer.js' },
      // main/custom js
      // { src: '/assets/js/script.js' }
    ]
  },

  server: {
    host: process.env.host || "0.0.0.0",
    port: process.env.port || 3000, // default: 3000
  },

  // Global CSS: https://go.nuxtjs.dev/config-css
  css: [
    'element-ui/lib/theme-chalk/index.css'
  ],

  // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
  plugins: [
    '@/plugins/element-ui',
    '@/plugins/vuelidate.client.js',
    '@/plugins/axios.js'
  ],

  // Auto import components: https://go.nuxtjs.dev/config-components
  components: true,

  // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
  buildModules: [
  ],

  // Modules: https://go.nuxtjs.dev/config-modules
  modules: [
    // https://go.nuxtjs.dev/axios
    '@nuxtjs/axios',
  ],

  // Build Configuration: https://go.nuxtjs.dev/config-build
  build: {
    transpile: [/^element-ui/],
  },

  env:{
    baseUrl: process.env.API_BASE_URL || 'http://127.0.0.1:8061',
    recaptchaKeys: '6LdBbaQbAAAAAKpoINBgNp6mPz_CKsjxnY-ObktE',
    port: process.env.PORT || 3000,
    host: process.env.APP_HOST || "0.0.0.0",
  },

  loading: {
    color: '#159c45',
    height: '3px'
  },

  router: {
    linkActiveClass: '',
    linkExactActiveClass: 'active'
  }
}
