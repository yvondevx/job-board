<script setup lang="ts">
definePageMeta({ layout: 'guest' })

const { apiFetch } = useApi()
const authStore    = useAuthStore()

const form  = reactive({ email: '', password: '' })
const error = ref('')
const loading = ref(false)

async function login() {
  loading.value = true
  error.value   = ''
  try {
    const res = await apiFetch<{ token: string; user: { id: number; name: string; email: string } }>(
      '/login',
      { method: 'POST', body: form }
    )
    authStore.setAuth(res.token, res.user)
    await navigateTo('/')
  } catch {
    error.value = 'Invalid credentials. Please try again.'
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="max-w-md w-full bg-white rounded-xl shadow p-8">
      <h1 class="text-2xl font-bold text-gray-900 mb-6">Sign In</h1>

      <p v-if="error" class="mb-4 text-sm text-red-600 bg-red-50 rounded p-3">{{ error }}</p>

      <div class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
          <input
            v-model="form.email"
            type="email"
            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
            placeholder="you@example.com"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
          <input
            v-model="form.password"
            type="password"
            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
            @keyup.enter="login"
          />
        </div>

        <button
          :disabled="loading"
          class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition disabled:opacity-50"
          @click="login"
        >
          {{ loading ? 'Signing in...' : 'Sign In' }}
        </button>
      </div>

      <p class="mt-4 text-sm text-center text-gray-500">
        Don't have an account?
        <NuxtLink to="/register" class="text-blue-600 hover:underline">Register</NuxtLink>
      </p>
    </div>
  </div>
</template>
