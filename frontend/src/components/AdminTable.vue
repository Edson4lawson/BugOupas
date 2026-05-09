<template>
  <div class="space-y-8">
    <!-- Statistiques -->
    <div v-if="stats" class="grid grid-cols-1 md:grid-cols-3 gap-8" data-aos="fade-up">
      <div class="relative overflow-hidden bg-gradient-to-br from-indigo-600 to-blue-600 rounded-[2rem] p-8 text-white shadow-xl shadow-blue-500/20 group hover:-translate-y-1 transition-transform duration-300">
        <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 bg-white/20 rounded-full blur-2xl group-hover:bg-white/30 transition-colors"></div>
        <div class="relative flex items-center justify-between z-10">
          <div>
            <p class="text-blue-100 text-xs font-bold uppercase tracking-widest mb-1">Total Réponses</p>
            <p class="text-5xl font-black tracking-tight">{{ stats.total }}</p>
          </div>
          <span class="iconify text-5xl text-blue-200/60" data-icon="solar:document-text-bold-duotone"></span>
        </div>
      </div>
      
      <div class="relative overflow-hidden bg-gradient-to-br from-purple-600 to-pink-600 rounded-[2rem] p-8 text-white shadow-xl shadow-purple-500/20 group hover:-translate-y-1 transition-transform duration-300">
        <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 bg-white/20 rounded-full blur-2xl group-hover:bg-white/30 transition-colors"></div>
        <div class="relative flex items-center justify-between z-10">
          <div>
            <p class="text-purple-100 text-xs font-bold uppercase tracking-widest mb-1">Domaines</p>
            <p class="text-5xl font-black tracking-tight">{{ stats.by_domain?.length || 0 }}</p>
          </div>
          <span class="iconify text-5xl text-purple-200/60" data-icon="solar:folder-with-files-bold-duotone"></span>
        </div>
      </div>
      
      <div class="relative overflow-hidden bg-gradient-to-br from-orange-500 to-red-500 rounded-[2rem] p-8 text-white shadow-xl shadow-orange-500/20 group hover:-translate-y-1 transition-transform duration-300">
         <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 bg-white/20 rounded-full blur-2xl group-hover:bg-white/30 transition-colors"></div>
        <div class="relative flex items-center justify-between z-10">
          <div>
            <p class="text-orange-100 text-xs font-bold uppercase tracking-widest mb-1">Frustration Moy.</p>
            <p class="text-5xl font-black tracking-tight">{{ averageFrustration }}</p>
          </div>
          <span class="iconify text-5xl text-orange-200/60" data-icon="solar:fire-bold-duotone"></span>
        </div>
      </div>
    </div>

    <!-- Filtres et Tableau -->
    <div class="card !p-0 overflow-hidden border-0" data-aos="fade-up" data-aos-delay="100">
      <!-- Filtres -->
      <div class="p-6 border-b border-indigo-50/50 bg-white/50 backdrop-blur-md">
        <div class="flex flex-wrap gap-6 items-end">
          <div class="flex-1 min-w-[200px]">
            <label class="label text-[10px] uppercase text-slate-400 font-bold tracking-widest mb-2 pl-1">Filtrer par domaine</label>
            <div class="relative group">
              <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-500 transition-colors pointer-events-none">
                  <span class="iconify" data-icon="solar:filter-bold"></span>
              </div>
              <select
                v-model="filterDomain"
                @change="applyFilters"
                class="input-field appearance-none cursor-pointer bg-white pl-10 h-12 !py-0 !border-slate-200"
              >
                <option value="">Tous les domaines</option>
                <option value="Santé">Santé</option>
                <option value="Éducation">Éducation</option>
                <option value="Finance">Finance</option>
                <option value="Commerce">Commerce</option>
                <option value="Transport">Transport</option>
                <option value="Autre">Autre</option>
              </select>
               <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                  <span class="iconify text-lg" data-icon="solar:alt-arrow-down-linear"></span>
                </span>
            </div>
          </div>
          
          <div class="flex-1 min-w-[200px]">
            <label class="label text-[10px] uppercase text-slate-400 font-bold tracking-widest mb-2 pl-1">Trier par</label>
            <div class="relative group">
               <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-500 transition-colors pointer-events-none">
                  <span class="iconify" data-icon="solar:sort-vertical-bold"></span>
              </div>
              <select
                v-model="sortBy"
                @change="applyFilters"
                class="input-field appearance-none cursor-pointer bg-white pl-10 h-12 !py-0 !border-slate-200"
              >
                <option value="created_at">Date de soumission</option>
                <option value="frustration">Niveau de frustration</option>
                <option value="domain">Domaine</option>
              </select>
              <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                  <span class="iconify text-lg" data-icon="solar:alt-arrow-down-linear"></span>
                </span>
            </div>
          </div>
          
          <div class="flex-none">
            <button
              @click="refreshData"
              class="h-12 w-12 rounded-xl bg-white border border-slate-200 hover:border-indigo-500 hover:text-indigo-600 text-slate-500 flex items-center justify-center transition-all duration-300 shadow-sm hover:shadow-md"
              :disabled="isLoading"
              title="Actualiser"
            >
              <span
                class="iconify text-xl"
                :class="{ 'animate-spin': isLoading }"
                data-icon="solar:refresh-bold"
              ></span>
            </button>
          </div>
        </div>
      </div>

      <!-- Tableau des réponses -->
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead>
            <tr class="bg-indigo-50/30 text-left border-b border-indigo-100/50">
              <th class="px-8 py-5 text-xs font-bold text-slate-500 uppercase tracking-wider w-20">
                #ID
              </th>
              <th class="px-6 py-5 text-xs font-bold text-slate-500 uppercase tracking-wider">
                Problème signalé
              </th>
              <th class="px-6 py-5 text-xs font-bold text-slate-500 uppercase tracking-wider w-40">
                Domaine
              </th>
              <th class="px-6 py-5 text-xs font-bold text-slate-500 uppercase tracking-wider w-40">
                Gravité
              </th>
              <th class="px-6 py-5 text-xs font-bold text-slate-500 uppercase tracking-wider w-48 text-right">
                Date
              </th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            <tr
              v-for="response in responses"
              :key="response.id"
              class="hover:bg-slate-50/80 transition-colors group cursor-default"
            >
              <td class="px-8 py-5 whitespace-nowrap text-sm font-semibold text-slate-400 group-hover:text-indigo-500 transition-colors">
                #{{ response.id }}
              </td>
              <td class="px-6 py-5 text-sm text-slate-700">
                <p class="line-clamp-2 md:line-clamp-none font-medium text-balance">{{ response.problem }}</p>
                <p v-if="response.custom_domain" class="text-xs text-slate-400 mt-1 italic">
                  Précision: {{ response.custom_domain }}
                </p>
              </td>
              <td class="px-6 py-5 whitespace-nowrap">
                <span
                  class="px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wide inline-flex items-center gap-1.5"
                  :class="getDomainClass(response.domain)"
                >
                  <span class="w-1.5 h-1.5 rounded-full bg-current opacity-50"></span>
                  {{ response.domain }}
                </span>
              </td>
              <td class="px-6 py-5 whitespace-nowrap">
                <div class="flex items-center gap-1">
                   <div class="flex gap-0.5" :title="getFrustrationLabel(response.frustration)">
                      <span
                        v-for="i in 5"
                        :key="i"
                        class="w-2 h-6 rounded-full transition-all duration-300"
                        :class="[
                          i <= response.frustration ? getFrustrationBarClass(response.frustration) : 'bg-slate-100',
                          i <= response.frustration ? 'scale-100' : 'scale-90'
                        ]"
                      ></span>
                    </div>
                </div>
              </td>
              <td class="px-6 py-5 whitespace-nowrap text-sm font-medium text-slate-500 text-right">
                {{ formatDate(response.created_at) }}
              </td>
            </tr>
            
            <tr v-if="responses.length === 0">
              <td colspan="5" class="py-20 text-center">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                   <span class="iconify text-4xl text-slate-400" data-icon="solar:archive-minimalistic-broken"></span>
                </div>
                <h3 class="text-lg font-medium text-slate-800">Aucune réponse trouvée</h3>
                <p class="text-slate-500">Essayez de modifier vos filtres</p>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'

const props = defineProps({
  responses: {
    type: Array,
    required: true
  },
  stats: {
    type: Object,
    default: null
  },
  isLoading: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['refresh', 'filter'])

const filterDomain = ref('')
const sortBy = ref('created_at')
const sortOrder = ref('DESC')

// Calculer la frustration moyenne
const averageFrustration = computed(() => {
  if (!props.stats?.by_domain || props.stats.by_domain.length === 0) return '0.0'
  
  const total = props.stats.by_domain.reduce((sum, item) => sum + parseFloat(item.avg_frustration || 0), 0)
  const avg = total / props.stats.by_domain.length
  return avg.toFixed(1)
})

// Fonction pour obtenir la classe CSS du domaine
const getDomainClass = (domain) => {
  const classes = {
    'Santé': 'bg-red-50 text-red-600',
    'Éducation': 'bg-blue-50 text-blue-600',
    'Finance': 'bg-green-50 text-green-600',
    'Commerce': 'bg-yellow-50 text-yellow-700',
    'Transport': 'bg-purple-50 text-purple-600',
    'Autre': 'bg-slate-50 text-slate-600'
  }
  return classes[domain] || 'bg-slate-100 text-slate-600'
}

const getFrustrationBarClass = (level) => {
  if (level <= 2) return 'bg-green-400'
  if (level === 3) return 'bg-yellow-400'
  return 'bg-red-500'
}

const getFrustrationLabel = (level) => {
  return ['Faible', 'Moyen', 'Modéré', 'Élevé', 'Critique'][level - 1]
}

// Fonction pour formater la date
const formatDate = (dateString) => {
  const date = new Date(dateString)
  return new Intl.DateTimeFormat('fr-FR', {
    day: 'numeric',
    month: 'short',
    hour: '2-digit',
    minute: '2-digit'
  }).format(date)
}

// Appliquer les filtres
const applyFilters = () => {
  emit('filter', {
    domain: filterDomain.value,
    sortBy: sortBy.value,
    sortOrder: sortOrder.value
  })
}

// Actualiser les données
const refreshData = () => {
  emit('refresh')
}
</script>

<style scoped>
.text-balance {
  text-wrap: balance;
}
</style>
