import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import Admin from '../views/Admin.vue'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
    meta: {
      title: 'Accueil - Sondage Digital Bénin'
    }
  },
  {
    path: '/admin',
    name: 'Admin',
    component: Admin,
    meta: {
      title: 'Administration - Sondage Digital Bénin'
    }
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

// Mettre à jour le titre de la page
router.beforeEach((to, from, next) => {
  document.title = to.meta.title || 'Sondage Digital Bénin'
  next()
})

export default router
