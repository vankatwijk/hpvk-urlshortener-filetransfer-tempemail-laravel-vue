<template>
    <div class="flex flex-row rounded mt-5 bg-white p-6 shadow w-full items-center cursor-pointer pointer select-none"
         :class="{ 'selected' : selected }">

        <div class="flex flex-col items-center bg-teal-100 text-teal-500 p-3 rounded">
            <i class="fas fa-eye text-xl"></i>
            <p class="mt-1">{{ link.totalClicks }}</p>
        </div>
        <div class="flex flex-col items-center bg-teal-100 text-teal-500 p-3 ml-3 rounded" @click="addRemoveTree(link)">
            <i class="fas fa-tree text-xl"></i>
            <p class="mt-1">{{ link.intree }}</p>
        </div>
        <div class="flex flex-col items-center bg-red-100 text-teal-500 p-3 ml-3 rounded" @click="removeLink(link)">
            <i class="fas fa-trash text-xl"></i>
            <p class="mt-1">0</p>
        </div>
        <div class="flex flex-col ml-6 sm:ml-8">
            <a :href="'/' + link.short" class="text-teal-600 font-semibold hover:underline">{{ APP_URL }}/{{ link.short }}</a>
            <a :href="link.original" class="text-teal-500 mt-1 hover:underline">{{ link.original | truncate(30) }}</a>
        </div>
    </div>
</template>

<script>
  import LinksClient from '../../api/links'

  export default {
    name: 'LinksListItem',

    props: ['link', 'selected'],

    data() {
      return {
        APP_URL: process.env.MIX_APP_URL,
      }
    },

    methods: {
      
      async removeLink (link) {

        try {
          const response = await LinksClient.removeLink(link)
          this.$emit('UpdateLinks', response.data)
          
        } catch (error) {
          this.$swal({
            type: 'error',
            title: 'Oops...',
            text: 'There was an error loading your past links.',
          })
        } finally {
          this.isLoading = false
        }

      },
      async addRemoveTree (link) {

        try {
          const response = await LinksClient.addRemoveLinkTree(link)
          this.$emit('UpdateLinks', response.data)
          
        } catch (error) {
          this.$swal({
            type: 'error',
            title: 'Oops...',
            text: 'There was an error loading your past links.',
          })
        } finally {
          this.isLoading = false
        }

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
