<template>
    <div class="p-3">
        <transition appear name="fade">
            <shorten-link-form @addToPreviousLinks="addToPreviousLinks" class="sm:w-full md:w-2/3"></shorten-link-form>
        </transition>

        <transition appear name="fade" mode="out-in">
            <links-list :links="previousLinks" v-if="previousLinks.length > 0" class="rounded mt-10 bg-white p-6 shadow w-full md:w-2/3 mx-auto">
                <template #list-title>Links</template>
                <template #list-item="{ link, selected }">
                    <previous-links-list-item :link="link" :selected="selected"></previous-links-list-item>
                </template>
            </links-list>

            <div v-if="previousLinks.length === 0" class="md:w-2/3 mt-10 mx-auto">
                <notification>
                    <template #title>Hey!</template>
                    <template #body>
                        <p>This feels empty...</p>
                        <p>Start by adding some links 👆</p>
                        <p>Then view your dashboard for some <span>📈</span></p>
                    </template>
                </notification>
            </div>
        </transition>

        <div class="flex flex-row text-gray-600 justify-center mt-12">
            <a href="http://github.com/eacdev/laravel-url-shortener">View the code on <i class="fab fa-github"></i></a>
        </div>
    </div>
</template>

<script>
  export default {
    name: 'ShortenLinkPage',

    data () {
      return {
        previousLinks: [],
      }
    },

    methods: {
      addToPreviousLinks (link) {
        if (this.previousLinks.length >= 3) {
          this.previousLinks.splice(-1)
        }

        this.previousLinks.unshift(link)
      },
    }
  }
</script>

<style scoped>
</style>
