<template>
    <div>
        <p class="uppercase font-semibold text-gray-600 pt-5">
            Clicks
        </p>

        <div v-for="click in clicks" :key="click.id" class="flex flex-row rounded mt-5 text-teal-500 bg-white p-2 shadow w-full items-center cursor-pointer pointer select-none overflow-hidden">
          <div class="w-2/6 p-1">
            <div class="flex flex-col items-center bg-teal-100 text-teal-500 p-1 rounded">
                <!--i class="fas fa-clock text-xl"></i-->
                <p class="mt-1">{{click.created_at | momentDayTime}}</p>
            </div>
          </div>
          <div class="w-2/6 p-1">
            <div class="flex flex-col items-center bg-teal-100 text-teal-500 p-1 rounded">
                <i class="fas fa-globe-europe text-xl"></i>
                <p class="mt-1" v-if="click.countryName">{{click.countryName}}</p>
            </div>
          </div>
          <div class="w-2/6 p-1">

            <div class="flex flex-col items-center bg-red-100 text-teal-500 p-1 rounded">
                <!--i class="fab fa-grav text-xl"></i-->
                <p class="mt-1" v-if="click.latitude">{{click.latitude +" "+ click.longitude}}</p>
            </div>

          </div>
        </div>
    </div>
</template>

<script>
  import LinksClient from '../../api/links'

  export default {
    name: 'clickList',

    props: ['link_id'],

    data () {
      return {
        clicks:[]
      }
    },

    methods: {
    },
    watch: {
        // whenever question changes, this function will run
        async link_id(newID, oldID) {
          try {
            const response = await LinksClient.getAllClicksForLink(newID)
            this.clicks = response.data

          } catch (error) {
            this.$swal({
              type: 'error',
              title: 'Oops...',
              text: 'There was an error loading your clicks.' + error,
            })
          } finally {
            this.isLoading = false
          }
        }
    },
    async mounted () {
      try {
        const response = await LinksClient.getAllClicksForLink(this.link_id)
        this.clicks = response.data

      } catch (error) {
        this.$swal({
          type: 'error',
          title: 'Oops...',
          text: 'There was an error loading your clicks.' + error,
        })
      } finally {
        this.isLoading = false
      }
    }

  }
</script>

<style scoped>
</style>
