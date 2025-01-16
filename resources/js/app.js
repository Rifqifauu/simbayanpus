import { createApp } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import '../css/app.css' // Or your relative path

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    return pages[`./Pages/${name}.vue`]
  },
  setup({ el, App, props, plugin }) {
    createApp(App, props)
      .use(plugin)
      .mount(el)
  },
})
