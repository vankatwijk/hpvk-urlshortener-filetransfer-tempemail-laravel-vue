<template>
    <div>
        <clip-loader :loading="isLoading" :color="'#805ad5'" :size="'21px'" class="mx-auto self-center"></clip-loader>

        <transition appear name="fade" mode="out-in">
          <div class="">

            <img v-if="!user.avatar" onclick="document.getElementById('file').click();" class="flex md:w-1/12 p-2 mb-6 mx-auto shadow rounded-full" src="https://upload.wikimedia.org/wikipedia/commons/7/7c/Profile_avatar_placeholder_large.png" alt="Profile image"/>
            <img v-if="user.avatar" onclick="document.getElementById('file').click();" class="flex md:w-1/12 p-2 mb-6 mx-auto shadow rounded-full" :src="APP_URL+'/storage/'+user.avatar" alt="Profile image"/>
            
            <input @change="upload" type="file" style="display:none;" id="file" name="file"/>

            <span class="flex md:w-4/12 p-2 mb-6 mx-auto shadow rounded-full">
              <a :href="APP_URL+'tree/'+treeLink" class="text-blue-500 hover:underline">{{APP_URL+'/tree/'+treeLink}}</a>
            </span>
          </div>

        </transition>

        <transition appear name="fade" mode="out-in">
            <notification v-if="selectedLink.totalClicks === 0" class="md:w-2/3 mx-auto">
                <template #title>Hey!</template>
                <template #body>
                    <p class="mt-2">This link doesn't have any clicks...</p>
                    <p>Once it gets a couple, we'll be able to show you a nice graph.</p>
                </template>
            </notification>

            <link-chart v-if="selectedLink.totalClicks > 0"
                        :class="'w-full md:w-2/3 p-2 mx-auto shadow bg-white rounded'"
                        :height="150"
                        :chart-data="this.selectedLink.clicksByMonth"
                        :chart-labels="chartLabels"
                        ></link-chart>
        </transition>

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
            <links-list :links="links" v-if="links.length > 0" class="mt-10 w-full md:w-2/3 mx-auto" v-model="selectedLink">
                <template #list-title>Your links</template>
                <template #list-item="{ link, selected }">
                    <links-list-item :link="link" :selected="selected" @UpdateLinks="UpdateLinks"></links-list-item>
                </template>
            </links-list>
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
        user:{},
        treeLink:''
      }
    },

    async mounted () {
      let vm = this

      try {
        const response = await LinksClient.getAllTreeLinksForUser()
        console.log('treedashboard',response.data);

        vm.user = response.data.user;
        vm.treeLink = response.data.link;
        response.data.tree.forEach(function (link) {
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
      async upload(e) {

        var files = e.target.files || e.dataTransfer.files;
        if (!files.length){
          return;

        }else{
          console.log('file has size');
          this.isLoading = true;
          this.file = e.target.files[0];

          const data = {
            original: '@avatar',
            file:  this.file
          }

          try {
            const response = await LinksClient.uploadAvatar(data)
            this.user = response.data;
          } catch (error) {

            console.log('error',error);
            this.$swal({
              type: 'error',
              title: 'Oops...',
              text: 'Something went wrong!',
              confirmButtonColor: '#805ad5',
            })
          } finally {
            this.isLoading = false
          }

        }
      },
      UpdateLinks (links) {

        this.links = links.filter(link => link.intree === 1);

      },
    }
  }
</script>

<style scoped>
</style>
