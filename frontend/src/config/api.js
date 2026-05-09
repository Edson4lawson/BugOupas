// Configuration de l'API
// Utilise les variables d'environnement de Vite

const API_URL = import.meta.env.VITE_API_URL || 'http://localhost:8000'

export const config = {
  apiUrl: API_URL,
  endpoints: {
    submit: `${API_URL}/submit.php`,
    admin: `${API_URL}/admin.php`
  }
}

export default config
