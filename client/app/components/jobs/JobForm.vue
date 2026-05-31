<script setup lang="ts">
defineProps<{
  form: {
    category_id:    number | null
    subcategory_id: number | null
    author_id:      number | null
    title:          string
    slug:           string
    description:    string
    location:       string
    suburb:         string
    price_offer:    number | null
    type:           string
    status:         string
  }
  loading?: boolean
}>()

defineEmits<{ (e: 'submit'): void }>()
</script>

<template>
  <div class="space-y-5">

    <!-- Title -->
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Title <span class="text-red-500">*</span></label>
      <input
        v-model="form.title"
        type="text"
        placeholder="e.g. Senior Vue Developer"
        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
      />
    </div>

    <!-- Slug -->
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
      <input
        v-model="form.slug"
        type="text"
        placeholder="e.g. senior-vue-developer"
        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
      />
    </div>

    <!-- Description -->
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
      <textarea
        v-model="form.description"
        rows="5"
        placeholder="Describe the job role, responsibilities..."
        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none resize-none"
      />
    </div>

    <!-- Location + Suburb -->
    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
        <input
          v-model="form.location"
          type="text"
          placeholder="e.g. Manila"
          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
        />
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Suburb</label>
        <input
          v-model="form.suburb"
          type="text"
          placeholder="e.g. Makati"
          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
        />
      </div>
    </div>

    <!-- Price Offer -->
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Price Offer</label>
      <div class="relative">
        <span class="absolute left-3 top-2.5 text-gray-400 text-sm">₱</span>
        <input
          v-model="form.price_offer"
          type="number"
          min="0"
          step="0.01"
          placeholder="0.00"
          class="w-full border border-gray-300 rounded-lg pl-7 pr-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
        />
      </div>
    </div>

    <!-- Type + Status -->
    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
        <select
          v-model="form.type"
          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
        >
          <option value="">Select type</option>
          <option value="full-time">Full-Time</option>
          <option value="part-time">Part-Time</option>
          <option value="contract">Contract</option>
          <option value="remote">Remote</option>
          <option value="freelance">Freelance</option>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
        <select
          v-model="form.status"
          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
        >
          <option value="">Select status</option>
          <option value="active">Active</option>
          <option value="inactive">Inactive</option>
          <option value="draft">Draft</option>
        </select>
      </div>
    </div>

    <!-- IDs (optional metadata) -->
    <div class="grid grid-cols-3 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Category ID</label>
        <input
          v-model="form.category_id"
          type="number"
          placeholder="e.g. 1"
          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
        />
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Subcategory ID</label>
        <input
          v-model="form.subcategory_id"
          type="number"
          placeholder="e.g. 3"
          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
        />
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Author ID</label>
        <input
          v-model="form.author_id"
          type="number"
          placeholder="e.g. 5"
          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none"
        />
      </div>
    </div>

    <!-- Submit -->
    <button
      :disabled="loading"
      class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition disabled:opacity-50"
      @click="$emit('submit')"
    >
      {{ loading ? 'Saving...' : 'Save Job' }}
    </button>

  </div>
</template>
