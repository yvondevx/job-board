export interface Job {
  id: number
  external_id?: number
  category_id?: number
  subcategory_id?: number
  author_id?: number
  title: string
  slug?: string
  description?: string
  location?: string
  suburb?: string
  price_offer?: number | null
  type?: string
  status?: string
  photos?: string[]
  meta?: Record<string, unknown>
  created_at?: string
  updated_at?: string
}

export interface JobPagination {
  current_page: number
  last_page: number
  per_page: number
  total: number
}

export function useJobs() {
  const { apiFetch } = useApi()

  const jobs       = ref<Job[]>([])
  const currentJob = ref<Job | null>(null)
  const pagination = ref<JobPagination | null>(null)
  const loading    = ref(false)
  const error      = ref<string | null>(null)

  async function fetchJobs(page = 1, search = '', include: string | string[] = '') {
    loading.value = true
    error.value   = null
    try {
      const includeParam = Array.isArray(include)
        ? include.length ? include : undefined
        : include?.trim() ? include : undefined
      const res = await apiFetch<{ data: Job[]; meta: JobPagination }>('/jobs', {
        params: {
          page,
          ...(includeParam ? { include: includeParam } : {}),
          ...(search ? { 'filter[search]': search } : {}),
        },
      })
      jobs.value       = res.data
      pagination.value = res.meta
    } catch (e: unknown) {
      error.value = (e as Error).message ?? 'Failed to fetch jobs.'
    } finally {
      loading.value = false
    }
  }

  async function fetchJob(id: number) {
    loading.value = true
    error.value   = null
    try {
      const res        = await apiFetch<{ data: Job }>(`/jobs/${id}`)
      currentJob.value = res.data
    } catch (e: unknown) {
      error.value = (e as Error).message ?? 'Failed to fetch job.'
    } finally {
      loading.value = false
    }
  }

  async function createJob(payload: Partial<Job>) {
    return apiFetch<{ data: Job }>('/jobs', { method: 'POST', body: payload })
  }

  async function updateJob(id: number, payload: Partial<Job>) {
    return apiFetch<{ data: Job }>(`/jobs/${id}`, { method: 'PUT', body: payload })
  }

  async function deleteJob(id: number) {
    return apiFetch(`/jobs/${id}`, { method: 'DELETE' })
  }

  return {
    jobs, currentJob, pagination, loading, error,
    fetchJobs, fetchJob, createJob, updateJob, deleteJob,
  }
}
