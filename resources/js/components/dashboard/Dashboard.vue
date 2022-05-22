<template>
    <div>

        <transition appear name="fade">
            <notification v-if="links.length === 0 && !isLoading" class="md:w-2/3 mt-10 mx-auto">
                <template #title>Hey!</template>
                <template #body>
                    <p>There's nothing here...</p>
                    <a href="/" class="text-blue-500 hover:underline">Start by adding some links ✨</a>
                </template>
            </notification>
        </transition>

        <transition appear name="fade">

        <div class="flex flex-wrap md:flex-no-wrap bg-grey-lighter mx-auto md:w-5/6">

            <div class="mt-10 w-full md:w-3/6 p-2">
              <div class="text-white text-center bg-grey-light p-2">
              
                <clip-loader :loading="isLoading" :color="'#805ad5'" :size="'21px'" class="w-full self-center"></clip-loader>

                <transition appear name="fade" mode="out-in">
                    <notification v-if="selectedLink.totalClicks === 0" class="md:w-2/3 mx-auto">
                        <template #title>Hey!</template>
                        <template #body>
                            <p class="mt-2">This link doesn't have any clicks...</p>
                            <p>Once it gets a couple, we'll be able to show you a nice graph.</p>
                        </template>
                    </notification>

                    <link-chart v-if="selectedLink.totalClicks > 0"
                                :class="'w-full mx-auto shadow bg-white rounded'"
                                :height="150"
                                :chart-data="this.selectedLink.clicksByMonth"
                                :chart-labels="chartLabels"
                    ></link-chart>

                </transition>
                <transition appear name="fade" mode="out-in">

                    <click-list v-if="selectedLink.totalClicks > 0" :link_id="selectedLink.id"></click-list>
                    
                </transition>

              </div>
            </div>
            <div class="mt-10 w-full md:w-3/6 p-2">

              <div class="text-white text-center bg-grey-light p-2">
              
                <transition appear name="fade">
                    <links-list :links="links" v-if="links.length > 0" class="w-full text-left" v-model="selectedLink">
                        <template #list-title>Your links</template>
                        <template #list-item="{ link, selected }">
                            <links-list-item :link="link" :selected="selected" @UpdateLinks="UpdateLinks"></links-list-item>
                        </template>
                    </links-list>
                </transition>

              </div>
              
            </div>

          </div>

        </transition>

    </div>
</template>

<script>
  import LinksClient from '../../api/links'

  export default {
    name: 'Dashboard',

    data () {
      return {
        APP_URL: process.env.MIX_APP_URL,

        selectedLink: {},

        chartLabels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],

        links: [],

        isLoading: true,
      }
    },

    async mounted () {
      let vm = this

      try {
        const response = await LinksClient.getAllLinksForUser()
        response.data.forEach(function (link) {
          vm.links.push(link)
        })
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

    methods: {
      UpdateLinks (links) {

        this.links = links;

      },
    }
  }
</script>

<style scoped>
</style>