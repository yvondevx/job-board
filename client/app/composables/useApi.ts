// Global $fetch wrapper — injects Bearer token automatically
export function useApi() {
  const config    = useRuntimeConfig()
  const authStore = useAuthStore()

  async function apiFetch<T>(url: string, options: Record<string, unknown> = {}): Promise<T> {
    return $fetch<T>(url, {
      baseURL: config.public.apiBase,
      headers: {
        Accept: 'application/json',
        ...(authStore.token
          ? { Authorization: `Bearer ${authStore.token}` }
          : {}),
      },
      ...options,
    })
  }

  return { apiFetch }
}
