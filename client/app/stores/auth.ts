import { defineStore } from 'pinia'

interface User {
  id: number
  name: string
  email: string
}

export const useAuthStore = defineStore('auth', () => {
  const token = ref<string | null>(null)
  const user  = ref<User | null>(null)

  const isAuthenticated = computed(() => !!token.value)

  function init() {
    const cookie = useCookie<string>('auth_token')
    if (cookie.value) token.value = cookie.value
  }

  function setAuth(t: string, u: User) {
    token.value = t
    user.value  = u
    const cookie = useCookie('auth_token', {
      maxAge: 60 * 60 * 24,
      path: '/',
    })
    cookie.value = t
  }

  function logout() {
    token.value  = null
    user.value   = null
    useCookie('auth_token').value = null
    navigateTo('/login')
  }

  return { token, user, isAuthenticated, init, setAuth, logout }
})
