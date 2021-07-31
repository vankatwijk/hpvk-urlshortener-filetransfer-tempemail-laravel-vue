<template>
    <div class="flex flex-row mt-6 border-b border-gray-300 items-center pb-3">
        <i class="fas fa-link text-xl bg-purple-100 text-purple-500 p-2 rounded self-center"></i>
        <div class="flex flex-col ml-6 w-full">
            <a :href="'/' + link.short" class="text-purple-600 font-semibold">{{ APP_URL }}/{{ link.short }}</a>
            <a :href="link.original" class="text-purple-500">{{ link.original | truncate(25) }}</a>
        </div>
    </div>
</template>

<script>
  export default {
    name: 'PreviousLinksListItem',

    props: ['link', 'selected'],

    data() {
      return {
        APP_URL: process.env.MIX_APP_URL,
      }
    }
  }
</script>

<style scoped>

</style>
