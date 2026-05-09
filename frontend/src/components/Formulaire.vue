<template>
  <div class="card h-full flex flex-col justify-between relative overflow-hidden group !bg-white/80">
    <!-- Deco Header -->
    <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>

    <div class="mb-10 px-2 lg:px-4 pt-2">
      <div class="flex items-center justify-between mb-3">
        <h2 class="text-3xl font-black text-slate-800 flex items-center gap-3 tracking-tight font-brand">
          <span class="iconify text-indigo-600 text-2xl" data-icon="solar:pen-new-square-bold-duotone"></span>
          Un Bug ?
        </h2>
        <span class="badge bg-indigo-50 text-indigo-600 border border-indigo-100 px-2 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider shadow-sm">
          Anonyme
        </span>
      </div>
      <p class="text-slate-500 font-medium text-lg leading-relaxed">Détaillez votre expérience pour nous aider à comprendre.</p>
    </div>

    <div v-if="!isSuccess" class="space-y-8 flex-grow px-2 lg:px-4 pb-2 animate-fade-in">
        <form @submit.prevent="submitForm" class="space-y-8">
          <!-- Problème -->
          <div class="group-focus-within:text-indigo-600 transition-colors">
            <label for="problem" class="label mb-3 pl-1 flex items-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                Description du problème
            </label>
            <div class="relative group">
                 <div class="absolute top-5 left-5 pointer-events-none z-10">
                    <span class="iconify text-slate-400 text-xl group-focus-within:text-indigo-500 transition-colors" data-icon="solar:document-text-bold"></span>
                 </div>
                <textarea
                  id="problem"
                  v-model="form.problem"
                  class="input-field min-h-[160px] pl-14 pt-5 resize-none leading-relaxed text-lg"
                  placeholder="Décrivez ici le problème rencontré..."
                  required
                ></textarea>
                <div class="absolute bottom-4 right-4 text-[10px] font-bold text-slate-400 bg-slate-100 px-2 py-1 rounded-md">
                    {{ form.problem.length }} CARACTÈRES
                </div>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Domaine -->
            <div>
               <label for="domain" class="label mb-3 pl-1 flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span>
                    Domaine concerné
               </label>
              <div class="relative group">
                <div class="absolute left-5 top-1/2 -translate-y-1/2 pointer-events-none z-10 transition-transform group-focus-within:scale-110">
                    <span class="iconify text-slate-400 text-xl group-focus-within:text-purple-500 transition-colors" data-icon="solar:folder-with-files-bold"></span>
                </div>
                <select
                  id="domain"
                  v-model="form.domain"
                  class="input-field appearance-none cursor-pointer pl-14 h-[3.5rem]"
                  required
                >
                  <option value="" disabled selected>Choisir une catégorie...</option>
                  <option value="Santé">Santé & Bien-être</option>
                  <option value="Éducation">Éducation & Formation</option>
                  <option value="Finance">Finance & Banque</option>
                  <option value="Commerce">E-commerce & Achat</option>
                  <option value="Transport">Transport & Logistique</option>
                  <option value="Autre">Autre</option>
                </select>
                 <span class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                    <span class="iconify text-xl" data-icon="solar:alt-arrow-down-linear"></span>
                 </span>
              </div>
            </div>

            <!-- Précision (Si Autre) -->
            <transition name="fade">
                <div v-if="form.domain === 'Autre'">
                <label for="custom_domain" class="label mb-3 pl-1 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-pink-500"></span>
                        Précisez le domaine
                </label>
                <div class="relative group">
                        <div class="absolute left-5 top-1/2 -translate-y-1/2 pointer-events-none z-10">
                        <span class="iconify text-slate-400 text-xl group-focus-within:text-pink-500 transition-colors" data-icon="solar:pen-bold"></span>
                        </div>
                    <input
                        id="custom_domain"
                        v-model="form.custom_domain"
                        type="text"
                        class="input-field pl-14 h-[3.5rem]"
                        placeholder="Ex: Agriculture"
                        required
                    />
                </div>
                </div>
            </transition>
          </div>

          <!-- Frustration -->
          <div class="bg-gradient-to-br from-slate-50 to-white rounded-3xl p-6 border border-slate-100 shadow-inner">
            <label class="label text-center mb-8 !text-base !normal-case">Quel est votre niveau de frustration ?</label>
            
            <div class="flex flex-wrap justify-center items-center gap-2 md:gap-3 max-w-sm mx-auto relative px-2 mb-4">
                <!-- Ligne de fond -->
                <div class="absolute top-1/2 left-0 w-full h-2 bg-slate-100 rounded-full -z-10 shadow-inner hidden md:block"></div>
                
                <button
                    v-for="i in 5"
                    :key="i"
                    type="button"
                    @click="form.frustration = i"
                    class="relative group transition-all duration-300 focus:outline-none"
                >
                     <div 
                        class="w-12 h-12 md:w-14 md:h-14 rounded-full flex items-center justify-center border-[3px] transition-all duration-300 shadow-sm z-10 bg-white"
                        :class="[
                            form.frustration === i ? 'scale-125 border-white shadow-xl ' + getFrustrationColor(i) : 'border-white hover:scale-110 hover:border-indigo-50'
                        ]"
                     >
                        <span class="text-2xl md:text-3xl filter drop-shadow-sm transition-transform duration-300" :class="{ 'scale-110': form.frustration === i }">
                            {{ getFrustrationEmoji(i) }}
                        </span>
                     </div>
                </button>
            </div>
            
            <!-- Feedback text dynamique -->
            <div class="text-center h-8 flex items-center justify-center">
                <span v-if="form.frustration" class="text-sm font-bold animate-fade-in px-4 py-1.5 rounded-full bg-white shadow-sm border border-slate-100 inline-flex items-center gap-2" :class="getFrustrationTextClass(form.frustration)">
                    {{ getFrustrationLabel(form.frustration) }}
                     <span class="w-2 h-2 rounded-full" :class="getFrustrationDotClass(form.frustration)"></span>
                </span>
                <span v-else class="text-xs text-slate-400 font-medium">Sélectionnez une émoticône</span>
            </div>
          </div>

          <!-- Actions -->
          <div class="pt-6">
            <button
              type="submit"
              class="btn-primary w-full group !text-lg !py-5 shadow-indigo-500/25 hover:shadow-indigo-500/40"
              :disabled="isSubmitting"
            >
              <span v-if="!isSubmitting" class="flex items-center gap-3 font-bold tracking-wide">
                Envoyer mon avis
                <span class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center group-hover:translate-x-2 transition-transform duration-300">
                    <span class="iconify text-lg" data-icon="solar:plain-bold"></span>
                </span>
              </span>
              <span v-else class="flex items-center gap-3">
                <span class="iconify animate-spin text-2xl" data-icon="ei:spinner-3"></span> Envoi en cours...
              </span>
            </button>
          </div>
        </form>
    </div>

    <!-- Success View -->
    <div v-else class="flex-grow flex flex-col items-center justify-center text-center p-8 animate-fade-in">
        <div class="w-24 h-24 bg-green-50 rounded-full flex items-center justify-center mb-6 animate-bounce-slow">
            <span class="iconify text-5xl text-green-500" data-icon="solar:check-circle-bold-duotone"></span>
        </div>
        <h3 class="text-2xl font-black text-slate-800 mb-3">Merci pour votre avis !</h3>
        <p class="text-slate-500 mb-8 max-w-xs mx-auto text-lg">Votre contribution aide à améliorer le numérique au Bénin et dans le monde.</p>
        
        <button @click="resetForm" class="btn-secondary group">
            <span class="iconify text-xl transform group-hover:-rotate-90 transition-transform duration-500" data-icon="solar:refresh-bold-duotone"></span>
            Envoyer un autre avis
        </button>
    </div>
    
    <!-- Feedback Notification Comp (Error Only) -->
    <Feedback 
        v-if="feedback.message && feedback.isError" 
        :message="feedback.message" 
        :isError="feedback.isError" 
        @close="feedback.message = ''" 
    />
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'
import axios from 'axios'
import Feedback from './Feedback.vue'
import { config } from '@/config/api'

// Validation basique
const form = reactive({
  problem: '',
  domain: '',
  custom_domain: '',
  frustration: 0
})

const isSubmitting = ref(false)
const isSuccess = ref(false)

const feedback = reactive({
  message: '',
  isError: false
})

const getFrustrationEmoji = (level) => {
  return ['😐', '😕', '😩', '😠', '🤬'][level - 1]
}

const getFrustrationLabel = (level) => {
  return ['Gênant', 'Pénible', 'Frustrant', 'Très Énervant', 'Insupportable'][level - 1]
}

const getFrustrationColor = (level) => {
    switch(level) {
        case 1: return 'bg-green-50 ring-2 ring-green-400';
        case 2: return 'bg-yellow-50 ring-2 ring-yellow-400';
        case 3: return 'bg-orange-50 ring-2 ring-orange-400';
        case 4: return 'bg-red-50 ring-2 ring-red-500';
        case 5: return 'bg-purple-50 ring-2 ring-purple-600';
        default: return 'bg-slate-100';
    }
}

const getFrustrationTextClass = (level) => {
    switch(level) {
        case 1: return 'text-green-600';
        case 2: return 'text-yellow-600';
        case 3: return 'text-orange-600';
        case 4: return 'text-red-600';
        case 5: return 'text-purple-600';
        default: return 'text-slate-400';
    }
}

const getFrustrationDotClass = (level) => {
    switch(level) {
        case 1: return 'bg-green-500';
        case 2: return 'bg-yellow-500';
        case 3: return 'bg-orange-500';
        case 4: return 'bg-red-500';
        case 5: return 'bg-purple-600';
        default: return 'bg-slate-300';
    }
}

const resetForm = () => {
    form.problem = ''
    form.domain = ''
    form.custom_domain = ''
    form.frustration = 0
    isSuccess.value = false
    feedback.message = ''
}

const submitForm = async () => {
  if (!form.problem || !form.domain || !form.frustration) {
    feedback.message = 'Veuillez remplir tous les champs obligatoires'
    feedback.isError = true
    return
  }

  if (form.domain === 'Autre' && !form.custom_domain) {
    feedback.message = 'Veuillez préciser le domaine'
    feedback.isError = true
    return
  }

  isSubmitting.value = true
  
  // Préparation des données
  const submissionData = {
    problem: form.problem,
    domain: form.domain === 'Autre' ? 'Autre' : form.domain,
    custom_domain: form.domain === 'Autre' ? form.custom_domain : null,
    frustration: form.frustration,
    // Champs Formspree
    _subject: `Nouvel avis BugOuPas: ${form.domain}`,
    email: 'Anonyme' // Champ requis par certains config Formspree
  }

  try {
    // 1. Envoi au Backend Local (Base de données)
    const response = await axios.post(config.endpoints.submit, submissionData)
    
    if (response.data.success) {
      isSuccess.value = true
      
      // 2. Envoi silencieux à Formspree (Copie Email)
      // L'envoi se fera à cette adresse. Formspree enverra un mail de confirmation la première fois.
      const formspreeUrl = 'https://formspree.io/BugOuPas24@gmail.com' 
      
      axios.post(formspreeUrl, submissionData).catch(err => {
        console.warn('Erreur envoi copie email:', err)
        // On ne bloque pas l'utilisateur si l'email échoue, c'est secondaire
      })
    }
  } catch (error) {
    console.error('Erreur soumission:', error)
    feedback.message = error.response?.data?.message || 'Une erreur est survenue lors de l\'envoi.'
    feedback.isError = true
  } finally {
    isSubmitting.value = false
  }
}
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

.animate-fade-in {
    animation: fadeIn 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}

@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.9); }
    to { opacity: 1; transform: scale(1); }
}
</style>
