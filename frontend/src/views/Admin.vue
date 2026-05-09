<template>
  <div class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    <!-- Decorative Background Elements -->
    <div class="absolute top-[-10%] right-[-5%] w-[500px] h-[500px] bg-purple-300/30 rounded-full blur-[100px] animate-float"></div>
    <div class="absolute bottom-[-10%] left-[-5%] w-[500px] h-[500px] bg-blue-300/30 rounded-full blur-[100px] animate-float" style="animation-delay: -3s;"></div>

    <div class="w-full max-w-7xl relative z-10">
      <!-- Authentification View -->
      <transition name="page" mode="out-in">
        <div v-if="!isAuthenticated" class="max-w-md mx-auto" key="login">
          <!-- Logo / Header -->
          <div class="text-center mb-8" data-aos="fade-down">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white shadow-lg shadow-indigo-500/10 mb-6 rotate-3 hover:rotate-0 transition-transform duration-300 overflow-hidden">
               <img src="/BugOuPas-icone.png" alt="BugOuPas" class="w-full h-full object-cover">
            </div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Espace <span class="text-gradient">Admin</span></h1>
            <p class="text-slate-500 mt-2 font-medium">Accédez au tableau de bord sécurisé</p>
          </div>

          <!-- Login Card -->
          <div class="card backdrop-blur-2xl !bg-white/80 shadow-2xl shadow-indigo-500/10 border-0" data-aos="fade-up">
            <form @submit.prevent="handleLogin" class="space-y-6">
              <div>
                <label for="password" class="label">Code d'accès</label>
                <div class="relative group">
                  <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <span class="iconify text-slate-400 group-focus-within:text-indigo-500 transition-colors" data-icon="solar:lock-password-bold"></span>
                  </div>
                  <input
                    id="password"
                    v-model="password"
                    :type="showPassword ? 'text' : 'password'"
                    class="input-field pl-11 pr-12 !bg-slate-50/50"
                    placeholder="••••••••"
                    required
                  />
                  <button
                    type="button"
                    @click="showPassword = !showPassword"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-indigo-600 transition-colors p-1"
                  >
                    <span
                      class="iconify text-xl"
                      :data-icon="showPassword ? 'solar:eye-closed-bold' : 'solar:eye-bold'"
                    ></span>
                  </button>
                </div>
              </div>

              <transition name="fade">
                <div v-if="loginError" class="p-3 rounded-lg bg-red-50 text-red-600 text-sm font-medium flex items-center gap-2 border border-red-100">
                  <span class="iconify flex-shrink-0" data-icon="solar:danger-circle-bold"></span>
                  {{ loginError }}
                </div>
              </transition>

              <button
                type="submit"
                class="btn-primary w-full !rounded-xl text-lg group"
                :disabled="isLoggingIn"
              >
                <span v-if="!isLoggingIn" class="flex items-center gap-2">
                  Connexion <span class="iconify group-hover:translate-x-1 transition-transform" data-icon="solar:arrow-right-bold"></span>
                </span>
                <span v-else class="flex items-center gap-2">
                  <span class="iconify animate-spin" data-icon="ei:spinner-3"></span> Vérification...
                </span>
              </button>
            </form>
          </div>

          <div class="mt-8 text-center">
            <router-link to="/" class="inline-flex items-center gap-2 text-sm font-medium text-slate-400 hover:text-slate-600 transition-colors">
              <span class="iconify" data-icon="solar:arrow-left-linear"></span> Retour au site
            </router-link>
          </div>
        </div>

        <!-- Dashboard View -->
        <div v-else class="w-full" key="dashboard">
           <header class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6" data-aos="fade-down">
             <div>
                <h1 class="text-4xl font-extrabold text-slate-900 flex items-center gap-3">
                  <span class="text-gradient">Tableau de bord</span>
                </h1>
                <p class="text-slate-500 mt-2 font-medium">Analyse des retours utilisateurs en temps réel</p>
             </div>
             
             <div class="flex items-center gap-4">
               <button
                  @click="logout"
                  class="btn-secondary !text-sm !py-2.5 !px-5 bg-white/50 hover:bg-red-50 hover:text-red-600 hover:border-red-200"
                >
                  <span class="iconify text-lg" data-icon="solar:logout-2-bold"></span>
                  Déconnexion
                </button>
             </div>
           </header>

           <AdminTable
            :responses="responses"
            :stats="stats"
            :isLoading="isLoading"
            @refresh="fetchResponses"
            @filter="handleFilter"
          />
        </div>
      </transition>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import AdminTable from '../components/AdminTable.vue'
import { config } from '@/config/api'

// Charger Iconify - Géré globalement dans index.html

// État de l'authentification
const isAuthenticated = ref(false)
const password = ref('')
const loginError = ref('')
const isLoggingIn = ref(false)
const showPassword = ref(false)

// État des données
const responses = ref([])
const stats = ref(null)
const isLoading = ref(false)

// Paramètres de filtrage
const currentFilters = ref({
  domain: '',
  sortBy: 'created_at',
  sortOrder: 'DESC'
})

// Connexion admin
const handleLogin = async () => {
  loginError.value = ''
  isLoggingIn.value = true

  try {
    const response = await axios.post(config.endpoints.admin, {
      password: password.value
    })

    if (response.data.success) {
      isAuthenticated.value = true
      responses.value = response.data.data
      stats.value = response.data.stats
      // Stocker le mot de passe
      sessionStorage.setItem('adminPassword', password.value)
    }
  } catch (error) {
    console.error('Erreur de connexion:', error)
    loginError.value = error.response?.data?.message || 'Code d\'accès invalide'
  } finally {
    isLoggingIn.value = false
  }
}

// Récupérer les réponses
const fetchResponses = async () => {
  isLoading.value = true
  const adminPassword = sessionStorage.getItem('adminPassword')
  
  const params = new URLSearchParams({
    password: adminPassword,
    sortBy: currentFilters.value.sortBy,
    sortOrder: currentFilters.value.sortOrder
  })

  if (currentFilters.value.domain) {
    params.append('domain', currentFilters.value.domain)
  }

  try {
    const response = await axios.get(`${config.endpoints.admin}?${params.toString()}`)
    if (response.data.success) {
      responses.value = response.data.data
      stats.value = response.data.stats
    }
  } catch (error) {
    console.error('Erreur:', error)
    if (error.response?.status === 401) logout()
  } finally {
    isLoading.value = false
  }
}

const handleFilter = (filters) => {
  currentFilters.value = filters
  fetchResponses()
}

const logout = () => {
  isAuthenticated.value = false
  password.value = ''
  responses.value = []
  stats.value = null
  sessionStorage.removeItem('adminPassword')
}

onMounted(() => {
  const adminPassword = sessionStorage.getItem('adminPassword')
  if (adminPassword) {
    password.value = adminPassword
    handleLogin()
  }
})
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
