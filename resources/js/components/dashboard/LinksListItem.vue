<template>
    <div class="flex flex-row rounded mt-5 bg-white p-2 shadow w-full items-center cursor-pointer pointer select-none overflow-hidden"
         :class="{ 'selected' : selected }">

        <div class="flex flex-col items-center bg-teal-100 text-teal-500 p-2 h-16 mr-2 rounded" :style="(link.bg_color ? 'background-color:'+link.bg_color : '')">
        </div>

        <div class="flex flex-col items-center bg-teal-100 text-teal-500 p-2 rounded">
            <i class="fas fa-eye text-xl"></i>
            <p class="mt-1">{{ link.totalClicks }}</p>
        </div>
        <div class="flex flex-col items-center bg-teal-100 text-teal-500 p-2 ml-3 rounded" @click="showOptions(link)">
            <i class="fas fa-edit text-xl"></i>
            <p class="mt-1">{{ link.intree }}</p>
        </div>
        <div class="flex flex-col ml-6 sm:ml-3">
            <a :href="'/' + link.short"  target="_blank" class="text-teal-600 font-semibold hover:underline">{{ APP_URL }}/{{ link.short }}</a>


            <a v-if="link.label" :href="link.original"  target="_blank" class="text-teal-500 mt-1 hover:underline">{{ link.label | truncate(30) }}</a>
            <a v-else :href="link.original"  target="_blank" class="text-teal-500 mt-1 hover:underline">{{ link.original | truncate(30) }}</a>
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
    },

    methods: {
      async showOptions(link) {
        this.$emit('options', link.id)

      },
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
