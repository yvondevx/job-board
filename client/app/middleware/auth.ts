// Protects all routes that use definePageMeta({ middleware: 'auth' })
export default defineNuxtRouteMiddleware(() => {
  const authStore = useAuthStore()
  authStore.init() // rehydrate token from cookie

  if (!authStore.isAuthenticated) {
    return navigateTo('/login')
  }
})
