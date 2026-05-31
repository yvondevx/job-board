<script setup lang="ts">
definePageMeta({ middleware: 'auth' })

const { createJob } = useJobs()
const loading = ref(false)
const error   = ref('')

const form = reactive({
  category_id:    null as number | null,
  subcategory_id: null as number | null,
  author_id:      null as number | null,
  title:          '',
  slug:           '',
  description:    '',
  location:       '',
  suburb:         '',
  price_offer:    null as number | null,
  type:           '',
  status:         '',
})

async function submit() {
  loading.value = true
  error.value   = ''
  try {
    await createJob(form)
    await navigateTo('/')
  } catch {
    error.value = 'Failed to create job. Please try again.'
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <div class="max-w-2xl mx-auto px-4 py-8">
    <NuxtLink to="/" class="text-sm text-blue-600 hover:underline mb-4 inline-block">← Back</NuxtLink>
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Post a Job</h1>

    <p v-if="error" class="mb-4 text-sm text-red-600 bg-red-50 rounded p-3">{{ error }}</p>

    <JobForm :form="form" :loading="loading" @submit="submit" />
  </div>
</template>
