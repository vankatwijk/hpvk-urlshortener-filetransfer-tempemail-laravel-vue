<template>
    <a :href="'/' + link.short"  target="_blank" class="text-teal-600 font-semibold hover:underline">
      <div class="flex flex-row rounded mt-5 text-teal bg-white p-4 shadow w-full items-center cursor-pointer pointer select-none overflow-hidden selected"
          :class="{ 'selected' : selected }">

          <div class="flex flex-col items-center bg-red-100 text-teal-500 h-8 ml-3 rounded" >
              <img :src="'https://s2.googleusercontent.com/s2/favicons?domain='+link.original" alt="ico" />
          </div>
          <div class="flex flex-col ml-6 sm:ml-8">
              <span class="text-white mt-1 hover:underline">{{ filterProtocol(link.original) | truncate(60) }}</span>
          </div>
      </div>
    </a>
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
      filterProtocol(url){

        let cleanurl = url.match('^(?:https?:\/\/)?(?:[^@\/\n]+@)?(?:www\.)?([^:\/?\n]+)');
        return cleanurl[1];

      },
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
