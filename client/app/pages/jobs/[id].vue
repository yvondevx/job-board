<script setup lang="ts">
definePageMeta({ middleware: 'auth' })

const route = useRoute()
const { currentJob, fetchJob, loading } = useJobs()

await fetchJob(Number(route.params.id))
</script>

<template>
  <div class="max-w-3xl mx-auto px-4 py-8">
    <NuxtLink to="/" class="text-sm text-blue-600 hover:underline mb-4 inline-block">← Back to Jobs</NuxtLink>

    <div v-if="loading" class="text-gray-400">Loading...</div>

    <div v-else-if="currentJob" class="bg-white border border-gray-200 rounded-xl p-8 space-y-4">

      <!-- Title & Status -->
      <div class="flex items-start justify-between">
        <h1 class="text-3xl font-bold text-gray-900">{{ currentJob.title }}</h1>
        <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full font-medium">
          {{ currentJob.status }}
        </span>
      </div>

      <!-- Location & Suburb -->
      <p class="text-gray-500">
        📍 {{ currentJob.location }}
        <span v-if="currentJob.suburb"> · {{ currentJob.suburb }}</span>
      </p>

      <!-- Type -->
      <p v-if="currentJob.type" class="text-sm text-gray-500">
        🧳 {{ currentJob.type }}
      </p>

      <!-- Price Offer -->
      <p v-if="currentJob.price_offer" class="text-lg font-semibold text-blue-700">
        ₱{{ Number(currentJob.price_offer).toLocaleString('en-PH', { minimumFractionDigits: 2 }) }}
      </p>

      <!-- IDs -->
      <div class="flex gap-4 text-xs text-gray-400">
        <span v-if="currentJob.category_id">Category: {{ currentJob.category_id }}</span>
        <span v-if="currentJob.subcategory_id">Subcategory: {{ currentJob.subcategory_id }}</span>
        <span v-if="currentJob.author_id">Author: {{ currentJob.author_id }}</span>
      </div>

      <hr class="border-gray-100" />

      <!-- Description -->
      <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ currentJob.description }}</p>

      <!-- Photos -->
      <div v-if="currentJob.photos?.length" class="grid grid-cols-3 gap-3 mt-4">
        <img
          v-for="(photo, i) in currentJob.photos"
          :key="i"
          :src="photo"
          class="rounded-lg object-cover w-full h-32"
          alt="Job photo"
        />
      </div>

      <!-- Actions -->
      <div class="pt-4">
        <NuxtLink
          :to="`/jobs/${currentJob.id}/edit`"
          class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition"
        >
          Edit Job
        </NuxtLink>
      </div>

    </div>

    <p v-else class="text-gray-400">Job not found.</p>
  </div>
</template>
