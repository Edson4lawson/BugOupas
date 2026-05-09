<template>
  <transition name="slide-fade">
    <div
      v-if="show"
      class="fixed top-6 right-6 z-[100] max-w-sm w-full"
    >
      <div
        class="relative overflow-hidden rounded-2xl shadow-2xl backdrop-blur-xl border border-white/40 p-5 flex items-start gap-4"
        :class="isError 
          ? 'bg-red-500/10 text-red-600 shadow-red-500/10' 
          : 'bg-green-500/10 text-green-600 shadow-green-500/10'"
      >
        <!-- Icone -->
        <div class="flex-shrink-0">
           <div class="w-10 h-10 rounded-full flex items-center justify-center"
            :class="isError ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600'"
           >
              <span class="iconify text-xl" :data-icon="isError ? 'solar:danger-circle-bold' : 'solar:check-circle-bold'"></span>
           </div>
        </div>

        <!-- Contenu -->
        <div class="flex-1 pt-0.5">
          <h3 class="font-bold text-lg leading-tight mb-1" :class="isError ? 'text-red-700' : 'text-green-700'">
             {{ isError ? 'Oups !' : 'Parfait !' }}
          </h3>
          <p class="text-sm opacity-90 leading-snug text-slate-600 font-medium">
            {{ message }}
          </p>
        </div>

        <!-- Fermer -->
        <button
          @click="close"
          class="flex-shrink-0 text-slate-400 hover:text-slate-600 transition-colors p-1"
        >
          <span class="iconify text-xl" data-icon="solar:close-circle-bold"></span>
        </button>

         <!-- Barre de progression -->
        <div class="absolute bottom-0 left-0 w-full h-1 bg-current opacity-20">
            <div
                class="h-full bg-current transition-all duration-100 ease-linear"
                :style="{ width: progressWidth + '%' }"
            ></div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue'

// Charger Iconify
onMounted(() => {
  if (!document.querySelector('script[src*="iconify"]')) {
    const script = document.createElement('script')
    script.src = 'https://code.iconify.design/2/2.2.1/iconify.min.js'
    document.head.appendChild(script)
  }
})

const props = defineProps({
  message: {
    type: String,
    required: true
  },
  isError: {
    type: Boolean,
    default: false
  },
  duration: {
    type: Number,
    default: 5000
  }
})

const emit = defineEmits(['close'])

const show = ref(true)
const progressWidth = ref(100)

let timer = null
let progressTimer = null

// Fonction pour fermer le feedback
const close = () => {
  show.value = false
  emit('close')
  
  if (timer) clearTimeout(timer)
  if (progressTimer) clearInterval(progressTimer)
}

// Auto-fermeture après la durée spécifiée
watch(() => props.message, () => {
  show.value = true
  progressWidth.value = 100
  
  // Nettoyer les timers existants
  if (timer) clearTimeout(timer)
  if (progressTimer) clearInterval(progressTimer)
  
  // Timer pour fermer automatiquement
  timer = setTimeout(() => {
    close()
  }, props.duration)
  
  // Timer pour la barre de progression
  const interval = 50
  const steps = props.duration / interval
  const decrement = 100 / steps
  
  progressTimer = setInterval(() => {
    progressWidth.value -= decrement
    if (progressWidth.value <= 0) {
      clearInterval(progressTimer)
    }
  }, interval)
}, { immediate: true })
</script>

<style scoped>
.slide-fade-enter-active {
  transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}

.slide-fade-leave-active {
  transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateX(20px);
  opacity: 0;
}
</style>
