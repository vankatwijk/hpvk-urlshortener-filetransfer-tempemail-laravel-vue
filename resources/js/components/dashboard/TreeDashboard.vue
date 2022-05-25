<template>
    <div>
        <clip-loader :loading="isLoading" :color="'#805ad5'" :size="'21px'" class="mx-auto self-center"></clip-loader>

        <transition appear name="fade" mode="out-in">
          <div class="">

            <div class="flex flex-wrap md:flex-no-wrap bg-grey-lighter mx-auto md:w-5/6">
              <div class="mt-10 w-full md:w-3/6 p-2">

                <img v-if="!user.avatar" onclick="document.getElementById('file').click();" class="flex md:w-1/12 p-2 mb-6 mx-auto shadow rounded-full" src="https://upload.wikimedia.org/wikipedia/commons/7/7c/Profile_avatar_placeholder_large.png" alt="Profile image"/>
                <img v-if="user.avatar" onclick="document.getElementById('file').click();" class="flex md:w-1/12 p-2 mb-6 mx-auto shadow rounded-full" :src="APP_URL+'/storage/'+user.avatar" alt="Profile image"/>
                
                <input @change="upload" type="file" style="display:none;" id="file" name="file"/>

              </div>
              <div class="mt-10 w-full md:w-3/6 p-2">

                <span class="flex bg-white p-2 mb-6 mx-auto shadow rounded-full">
                  <a :href="APP_URL+'/t/'+treeLink" target="_blank" class="text-blue-500 hover:underline">{{APP_URL+'/t/'+treeLink}}</a>
                </span>

                <span class="flex bg-white p-2 mb-6 mx-auto shadow rounded-full">
                  <a :href="APP_URL+'/t/'+treeLink" target="_blank" class="text-blue-500 hover:underline">{{APP_URL+'/t/'+treeLink}}</a>
                </span>
                
              </div>
            </div>
          </div>

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
                      <shorten-link-form :intree="1" @addToPreviousLinks="getShortenLinks" class="w-full mb-5"></shorten-link-form>
                  </transition>
                
                  <transition appear name="fade">
                      <links-list :links="links" v-if="links.length > 0" class="w-full text-left" v-model="selectedLink">
                          <template #list-title>Your links</template>
                          <template #list-item="{ link, selected }">
                              <links-list-item :link="link" :selected="selected" @UpdateLinks="UpdateLinks" @options="showOptionsModal=true"></links-list-item>
                          </template>
                      </links-list>
                  </transition>

                </div>
                
              </div>

            </div>

        </transition>

        <transition appear name="fade">

            <v-modal v-if="showOptionsModal" title="Edit Link" width="sm" @close="showOptionsModal = false">
              <div class="text-gray-800">

                <div class="mb-4 px-2 w-full">
                  <label class="block mb-1 text-sm" for="input3">Label</label>
                  <input id="input3" class="w-full border-green-500 border px-4 py-2 rounded focus:border focus:border-blue-500 focus:shadow-outline outline-none" type="text" placeholder="" v-model="selectedLink.label"/>
                </div>

                <div class="mb-4 px-2 w-full">
                  <label class="block mb-1 text-sm" for="input3">Background Color</label>
                  <input id="input3" class="h-20 w-full border-green-500 border px-4 py-2 rounded focus:border focus:border-blue-500 focus:shadow-outline outline-none" type="color" v-model="selectedLink.bg_color" />
                </div>

                <div class="flex flex-row rounded mt-5 bg-white p-2 shadow w-full items-center cursor-pointer pointer select-none overflow-hidden">
                  <div class="flex flex-col items-center bg-teal-100 text-teal-500 p-2 ml-3 rounded" @click="switchLinkToTree(selectedLink);showOptionsModal = false;">
                      <i class="fas fa-tree text-xl"></i>
                      <p class="mt-1">{{ selectedLink.intree }}</p>
                  </div>
                  <div class="flex flex-col items-center bg-red-100 text-teal-500 p-2 ml-3 rounded" @click="deleteLink(selectedLink);showOptionsModal = false;">
                      <i class="fas fa-trash text-xl"></i>
                      <p class="mt-1">0</p>
                  </div>
                </div>


              </div>

              <div class="text-right mt-4">
                <button @click="showOptionsModal = false" class="px-4 py-2 text-sm text-gray-600 focus:outline-none hover:underline">Close</button>
                <button class="mr-2 px-4 py-2 text-sm rounded text-white bg-teal-500 focus:outline-none hover:bg-teal-400" @click="saveLinkChanges(selectedLink);showOptionsModal = false;">Save</button>
              </div>
            </v-modal>

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
        treeLink:'',
        showOptionsModal: false,
      }
    },

    async mounted () {
      this.getShortenLinks();
    },

    methods: {

      async getShortenLinks(){

        try {
          const response = await LinksClient.getAllTreeLinksForUser()
          console.log('treedashboard',response.data);

          this.user = response.data.user;
          this.treeLink = response.data.link;
          this.UpdateLinks(response.data.tree);
          // response.data.tree.forEach(function (link) {
          //   this.links.push(link)
          // })
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
      async deleteLink (link) {

        try {
          const response = await LinksClient.removeLink(link)
          this.UpdateLinks (response.data);
          
        } catch (error) {
          this.$swal({
            type: 'error',
            title: 'Oops...',
            text: 'There was an error deleting your link.',
          })
        } finally {
          this.isLoading = false
        }

      },
      async switchLinkToTree(link) {
        try {
          const response = await LinksClient.addRemoveLinkTree(link)
          this.UpdateLinks (response.data);
          
        } catch (error) {
          this.$swal({
            type: 'error',
            title: 'Oops...',
            text: 'There was an error switching the link to the link tree.',
          })
        } finally {
          this.isLoading = false
        }

      },
      async saveLinkChanges(link) {
        try {
          const response = await LinksClient.saveLinkChanges(link)
          this.UpdateLinks (response.data);
          
        } catch (error) {
          this.$swal({
            type: 'error',
            title: 'Oops...',
            text: 'There was an error saving changes to your link.',
          })
        } finally {
          this.isLoading = false
        }

      },


    }
  }
</script>

<style scoped>
</style>
