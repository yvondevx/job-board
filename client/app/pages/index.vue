<script setup lang="ts">
definePageMeta({ middleware: 'auth' })

const { jobs, pagination, loading, error, fetchJobs, deleteJob } = useJobs()
const authStore = useAuthStore()
const route = useRoute()
const router = useRouter()

function parsePage(value: string | string[] | undefined) {
  const pageString = Array.isArray(value) ? value[0] : value
  const pageNumber = Number(pageString)
  return Number.isInteger(pageNumber) && pageNumber > 0 ? pageNumber : 1
}

function parseSearch(value: string | string[] | undefined) {
  return Array.isArray(value) ? value[0] : value ?? ''
}

function parseInclude(value: string | string[] | undefined) {
  if (Array.isArray(value)) return value
  if (!value) return []
  return String(value).split(',').filter(Boolean)
}

const page = ref(parsePage(route.query.page))
const search = ref(parseSearch(route.query['filter[search]']))
const include = ref<string[]>(parseInclude(route.query.include))

function updateRouteQuery(pageValue: number, searchValue: string, includeValue: string[]) {
  const newQuery: Record<string, any> = { ...route.query, page: pageValue.toString() }
  if (includeValue && includeValue.length) newQuery.include = includeValue
  else delete newQuery.include
  if (searchValue) newQuery['filter[search]'] = searchValue
  else delete newQuery['filter[search]']
  void router.replace({ query: newQuery })
}

watch([page, search, include], ([p, s, inc], [oldP, oldS, oldInc]) => {
  // avoid unnecessary fetches on identical values
  const incJoined = Array.isArray(inc) ? inc.join(',') : inc ?? ''
  const oldIncJoined = Array.isArray(oldInc) ? oldInc.join(',') : oldInc ?? ''
  if (p === oldP && s === oldS && incJoined === oldIncJoined) return
  fetchJobs(p, s, inc)
  updateRouteQuery(p, s, Array.isArray(inc) ? inc : [])
})

onMounted(() => {
  fetchJobs(page.value, search.value, include.value)
  updateRouteQuery(page.value, search.value, include.value)
})

async function handleDelete(id: number) {
  if (!confirm('Delete this job?')) return
  await deleteJob(id)
  const inc = include.value
  const srch = search.value
  fetchJobs(page.value, srch, inc)
}
</script>

<template>
  <div class="max-w-5xl mx-auto px-4 py-8">

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold text-gray-900">Job Listings</h1>
      <div class="flex gap-3 items-center">
        <NuxtLink
          to="/jobs/create"
          class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition"
        >
          + Post Job
        </NuxtLink>
        <button
          class="text-sm text-gray-500 hover:text-red-600 transition"
          @click="authStore.logout()"
        >
          Logout
        </button>
      </div>
    </div>

    <!-- Include selector -->
    <div class="flex items-center gap-3 mb-4">
      <label class="text-sm text-gray-700">Include:</label>
      <label class="flex items-center gap-2">
        <input type="checkbox" value="photos" v-model="include" class="mt-0.5" />
        <span class="text-sm">Photos</span>
      </label>
      <label class="flex items-center gap-2">
        <input type="checkbox" value="author" v-model="include" class="mt-0.5" />
        <span class="text-sm">Author</span>
      </label>
    </div>

    <!-- Search -->
    <div class="mb-4">
      <input
        v-model="search"
        type="text"
        placeholder="Search by title, location, description..."
        class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-6 focus:ring-2 focus:ring-blue-500 outline-none"
      />
    </div>

    <!-- Error -->
    <p v-if="error" class="text-red-600 mb-4">{{ error }}</p>

    <!-- Loading -->
    <div v-if="loading" class="text-center py-12 text-gray-400">Loading...</div>

    <!-- Job Cards -->
    <div v-else class="space-y-4">
      <div
        v-for="job in jobs"
        :key="job.id"
        class="bg-white border border-gray-200 rounded-xl p-5 hover:shadow-md transition"
      >
        <div class="flex justify-between items-start gap-4">
          <div class="flex-1 min-w-0">
            <NuxtLink
              :to="`/jobs/${job.id}`"
              class="text-lg font-semibold text-blue-700 hover:underline"
            >
              {{ job.title }}
            </NuxtLink>

            <!-- Location + Suburb + Type -->
            <p class="text-sm text-gray-500 mt-1">
              📍 {{ job.location }}<span v-if="job.suburb"> · {{ job.suburb }}</span>
              <span v-if="job.type"> &nbsp;·&nbsp; 🧳 {{ job.type }}</span>
            </p>

            <!-- Price -->
            <p v-if="job.price_offer" class="text-sm font-semibold text-blue-600 mt-1">
              ₱{{ Number(job.price_offer).toLocaleString('en-PH', { minimumFractionDigits: 2 }) }}
            </p>

            <!-- Status -->
            <span class="inline-block mt-2 text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full">
              {{ job.status }}
            </span>
          </div>

          <!-- Actions -->
          <div class="flex gap-2 shrink-0">
            <NuxtLink
              :to="`/jobs/${job.id}/edit`"
              class="text-sm text-gray-500 hover:text-blue-600 border border-gray-200 rounded px-3 py-1 transition"
            >
              Edit
            </NuxtLink>
            <button
              class="text-sm text-red-500 hover:text-red-700 border border-red-200 rounded px-3 py-1 transition"
              @click="handleDelete(job.id)"
            >
              Delete
            </button>
          </div>
        </div>
      </div>

      <p v-if="!jobs.length && !loading" class="text-center text-gray-400 py-12">
        No jobs found.
      </p>
    </div>

    <!-- Pagination -->
    <div v-if="pagination && pagination.last_page > 1" class="flex justify-center gap-2 mt-8">
      <button
        v-for="p in pagination.last_page"
        :key="p"
        :class="[
          'px-3 py-1 rounded text-sm border transition',
          p === pagination.current_page
            ? 'bg-blue-600 text-white border-blue-600'
            : 'border-gray-300 text-gray-600 hover:bg-gray-50'
        ]"
        @click="page = p"
      >
        {{ p }}
      </button>
    </div>

  </div>
</template>
