<script setup lang="ts">
definePageMeta({ middleware: 'auth' })

const route  = useRoute()
const { currentJob, fetchJob, updateJob } = useJobs()
const loading = ref(false)
const error   = ref('')

await fetchJob(Number(route.params.id))

const form = reactive({
  category_id:    currentJob.value?.category_id    ?? null,
  subcategory_id: currentJob.value?.subcategory_id ?? null,
  author_id:      currentJob.value?.author_id      ?? null,
  title:          currentJob.value?.title          ?? '',
  slug:           currentJob.value?.slug           ?? '',
  description:    currentJob.value?.description    ?? '',
  location:       currentJob.value?.location       ?? '',
  suburb:         currentJob.value?.suburb         ?? '',
  price_offer:    currentJob.value?.price_offer    ?? null,
  type:           currentJob.value?.type           ?? '',
  status:         currentJob.value?.status         ?? '',
})

async function submit() {
  loading.value = true
  error.value   = ''
  try {
    await updateJob(Number(route.params.id), form)
    await navigateTo('/')
  } catch {
    error.value = 'Failed to update job.'
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <div class="max-w-2xl mx-auto px-4 py-8">
    <NuxtLink to="/" class="text-sm text-blue-600 hover:underline mb-4 inline-block">← Back</NuxtLink>
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Edit Job</h1>

    <p v-if="error" class="mb-4 text-sm text-red-600 bg-red-50 rounded p-3">{{ error }}</p>

    <JobForm :form="form" :loading="loading" @submit="submit" />
  </div>
</template>
