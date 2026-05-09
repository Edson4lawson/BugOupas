<template>
  <div class="relative min-h-screen overflow-hidden text-slate-800">
     <!-- Decorative Background Elements -->
    <div class="absolute top-[-20%] right-[-10%] w-[800px] h-[800px] bg-purple-400/20 rounded-full blur-[120px] animate-float pointer-events-none z-0"></div>
    <div class="absolute top-[40%] left-[-20%] w-[600px] h-[600px] bg-blue-400/20 rounded-full blur-[100px] animate-float pointer-events-none z-0" style="animation-delay: -4s;"></div>
    <div class="absolute bottom-[-10%] right-[20%] w-[500px] h-[500px] bg-pink-400/20 rounded-full blur-[100px] animate-float pointer-events-none z-0" style="animation-delay: -2s;"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 relative z-10">
      <!-- Header -->
      <header class="flex justify-end mb-12" data-aos="fade-down" data-aos-duration="800">
        <router-link
          to="/admin"
          class="group flex items-center gap-3 pl-5 pr-2 py-2 rounded-full bg-white/50 hover:bg-white/80 backdrop-blur-md border border-white/60 shadow-sm transition-all duration-300"
        >
          <span class="text-sm font-bold text-slate-600 group-hover:text-indigo-600 transition-colors">Espace Partenaire</span>
          <span class="w-8 h-8 rounded-full bg-indigo-500 text-white shadow-lg shadow-indigo-500/30 flex items-center justify-center group-hover:scale-110 group-hover:rotate-12 transition-all duration-300">
             <span class="iconify" data-icon="solar:shield-user-bold-duotone"></span>
          </span>
        </router-link>
      </header>

      <!-- Hero Section -->
      <div class="text-center mb-20 relative">
        <div class="inline-block mb-8 relative group cursor-default" data-aos="zoom-in" data-aos-delay="200">
          <div class="absolute inset-0 bg-gradient-to-tr from-indigo-500 to-purple-500 blur-2xl opacity-20 rounded-full group-hover:opacity-30 transition-opacity duration-500"></div>
          <div class="relative bg-white/80 backdrop-blur-xl p-6 rounded-[2rem] shadow-2xl shadow-indigo-500/10 animate-float border border-white/60 group-hover:scale-105 transition-transform duration-500">
            <img src="/BugOuPas-icone.png" alt="BugOuPas" class="w-24 h-24 object-cover hover:zoom-in transition-transform duration-500">
          </div>
        </div>

        <h1 class="text-6xl md:text-8xl font-black text-slate-900 mb-6 tracking-tight leading-[1.1] font-brand" data-aos="fade-up" data-aos-delay="300">
          <span class="text-slate-800">Bug</span><span class="text-gradient">OuPas</span>
        </h1>
        
        <p class="text-xl md:text-2xl text-slate-600 max-w-2xl mx-auto mb-12 leading-relaxed font-medium" data-aos="fade-up" data-aos-delay="400">
          Partagez vos défis numériques quotidiens et façonnez l'avenir de notre écosystème technologique.
        </p>

        <!-- Séparateur décoratif -->
        <div class="flex items-center justify-center gap-2 opacity-60" data-aos="scale-x" data-aos-delay="500">
           <div class="w-12 h-1 bg-indigo-500 rounded-full"></div>
           <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
           <div class="w-12 h-1 bg-pink-500 rounded-full"></div>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <!-- Informations (Gauche) -->
        <div class="lg:col-span-4 space-y-7 mt-11" data-aos="fade-right" data-aos-delay="600">
          <div class="card group hover:-translate-y-2 cursor-default border-l-4 border-l-transparent hover:border-l-indigo-500 transition-all">
            <div class="w-14 h-14 rounded-2xl bg-indigo-50 group-hover:bg-indigo-500 transition-colors duration-500 flex items-center justify-center mb-5 shadow-sm group-hover:shadow-lg group-hover:shadow-indigo-500/30">
              <span class="iconify text-3xl text-indigo-600 group-hover:text-white transition-colors duration-300" data-icon="solar:chat-round-line-bold-duotone"></span>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-3 group-hover:text-indigo-600 transition-colors">Exprimez-vous</h3>
            <p class="text-slate-600 leading-relaxed font-medium text-sm">
              Signalez les problèmes, bugs et frustrations que vous rencontrez avec les services digitaux au quotidien.
            </p>
          </div>

          <div class="card group hover:-translate-y-2 cursor-default border-l-4 border-l-transparent hover:border-l-purple-500 transition-all" data-aos="fade-right" data-aos-delay="700">
            <div class="w-14 h-14 rounded-2xl bg-purple-50 group-hover:bg-purple-500 transition-colors duration-500 flex items-center justify-center mb-5 shadow-sm group-hover:shadow-lg group-hover:shadow-purple-500/30">
              <span class="iconify text-3xl text-purple-600 group-hover:text-white transition-colors duration-300" data-icon="solar:graph-up-bold-duotone"></span>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-3 group-hover:text-purple-600 transition-colors">Analysez</h3>
            <p class="text-slate-600 leading-relaxed font-medium text-sm">
              Contribuez à une base de données ouverte pour identifier les points de friction majeurs du numérique béninois.
            </p>
          </div>

          <div class="card group hover:-translate-y-2 cursor-default border-l-4 border-l-transparent hover:border-l-pink-500 transition-all" data-aos="fade-right" data-aos-delay="800">
            <div class="w-14 h-14 rounded-2xl bg-pink-50 group-hover:bg-pink-500 transition-colors duration-500 flex items-center justify-center mb-5 shadow-sm group-hover:shadow-lg group-hover:shadow-pink-500/30">
              <span class="iconify text-3xl text-pink-600 group-hover:text-white transition-colors duration-300" data-icon="solar:rocket-bold-duotone"></span>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-3 group-hover:text-pink-600 transition-colors">Innovez</h3>
            <p class="text-slate-600 leading-relaxed font-medium text-sm">
              Vos retours sont le moteur qui guidera les développeurs vers des solutions plus adaptées et performantes.
            </p>
          </div>
        </div>

        <!-- Formulaire (Droite - Principal) -->
        <div class="lg:col-span-8 relative" data-aos="fade-left" data-aos-delay="600">
            <!-- Glow effect behind form -->
            <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-[2.5rem] opacity-20 blur-xl animate-pulse"></div>
            <div class="relative bg-white/60 backdrop-blur-2xl rounded-[2rem] p-1.5 border border-white/60 shadow-2xl shadow-indigo-200/20">
               <Formulaire />
            </div>
        </div>
      </div>

      <!-- Footer -->
      <footer class="mt-32 text-center border-t border-slate-200/60 pt-10 pb-6" data-aos="fade-up">
        <div class="flex items-center justify-center gap-2 mb-4 opacity-50">
           <span class="iconify text-2xl" data-icon="solar:code-square-bold-duotone"></span>
        </div>
        <p class="text-slate-500 font-medium font-brand tracking-wider">© {{ new Date().getFullYear() }} BugOuPas. <br class="md:hidden"/> <span class="text-indigo-500 font-sans tracking-normal">Ensemble pour un meilleur numérique.</span></p>
      </footer>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import Formulaire from '../components/Formulaire.vue'

// Les icônes sont maintenant chargées via index.html
</script>

<style scoped>
/* Les animations globales sont gérées dans style.css */
</style>
