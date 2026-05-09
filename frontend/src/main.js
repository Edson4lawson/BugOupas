import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import './style.css'

// AOS - Animate On Scroll
import AOS from 'aos'
import 'aos/dist/aos.css'

const app = createApp(App)

app.use(router)

// Initialiser AOS
app.mount('#app')

AOS.init({
  duration: 800,
  easing: 'ease-in-out',
  once: true,
  offset: 100
})
