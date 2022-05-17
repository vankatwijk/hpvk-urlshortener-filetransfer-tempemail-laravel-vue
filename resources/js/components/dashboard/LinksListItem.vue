<template>
    <div class="flex flex-row rounded mt-5 bg-white p-6 shadow w-full items-center cursor-pointer pointer select-none"
         :class="{ 'selected' : selected }">

        <div class="flex flex-col items-center bg-teal-100 text-teal-500 p-3 rounded">
            <i class="fas fa-eye text-xl"></i>
            <p class="mt-1">{{ link.totalClicks }}</p>
        </div>
        <div class="flex flex-col ml-6 sm:ml-8">
            <a :href="'/' + link.short" class="text-teal-600 font-semibold hover:underline">{{ APP_URL }}/{{ link.short }}</a>
            <a :href="link.original" class="text-teal-500 mt-1 hover:underline">{{ link.original | truncate(30) }}</a>
        </div>
    </div>
</template>

<script>
  export default {
    name: 'LinksListItem',

    props: ['link', 'selected'],

    data() {
      return {
        APP_URL: process.env.MIX_APP_URL,
      }
    }
  }
</script>

<style scoped>
    .selected {
        @apply bg-teal-600;
    }

    .selected a {
        @apply text-white;
    }
</style>
