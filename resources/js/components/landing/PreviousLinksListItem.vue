<template>
    <div class="flex flex-row mt-6 border-b border-gray-300 items-center pb-3">
        <button 
            type="button"
            v-clipboard:copy="APP_URL+'/'+link.short"
            v-clipboard:success="onCopy"
            v-clipboard:error="onError"
        >
          <i class="fas fa-copy text-xl bg-teal-100 text-teal-500 p-2 rounded self-center"></i>
        </button>

        <div class="flex flex-col ml-6 w-full">
            <a :href="'/' + link.short" class="text-teal-600 font-semibold">{{ APP_URL }}/{{ link.short }}</a>
            <a :href="link.original" class="text-teal-500">{{ link.original | truncate(25) }}</a>
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
    },
    methods: {
        onCopy: function (e) {
            //alert('You just copied the following text to the clipboard: ' + e.text)
        },
        onError: function (e) {
            //alert('Failed to copy the text to the clipboard')
            console.log(e);
        }
    }
  }
</script>

<style scoped>

</style>
