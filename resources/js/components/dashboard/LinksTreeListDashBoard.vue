<template>
    <div>
        <transition appear name="fade" mode="out-in">

              
            <div class="flex flex-wrap md:flex-no-wrap bg-grey-lighter mx-auto md:w-5/6 rounded" :style="(user.bg_color ? 'background-color:'+user.bg_color : '')">


              <div class="mt-10 w-full md:w-3/6 p-2">

                <div class="">

                  <img v-if="!user.avatar" class="flex md:w-4/12 p-2 mb-6 mx-auto shadow rounded-full" src="https://upload.wikimedia.org/wikipedia/commons/7/7c/Profile_avatar_placeholder_large.png" alt="Profile image"/>
                  <img v-if="user.avatar" class="flex md:w-4/12 p-2 mb-6 mx-auto shadow rounded-full" :src="APP_URL+'/storage/'+user.avatar" alt="Profile image"/>
                  
                  <span class="flex w-full bg-white p-2 mb-6 mx-auto rounded-full">
                    {{user.username}}
                  </span>

                  <span class="flex w-full  bg-white p-2 mb-6 mx-auto rounded-full">
                    {{user.description}}
                  </span>

                </div>

              </div>

              <div class="mt-10 w-full md:w-3/6 p-2">


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
                        <template #list-title>links</template>
                        <template #list-item="{ link, selected }">
                            <basic-links-list-item :link="link" :selected="selected" @UpdateLinks="UpdateLinks"></basic-links-list-item>
                        </template>
                    </links-list>
                </transition>


              </div>

            </div>


        </transition>
    </div>
</template>

<script>
  import LinksClient from '../../api/links'

  export default {
    name: 'LinksTreeDashBoard',

    props: ['links', 'user'],

    data () {
      return {
        APP_URL: process.env.MIX_APP_URL,
        selectedLink: {},
        chartLabels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        isLoading: true,
        treeLink:''
      }
    },

    async mounted () {
    },

    methods: {
    }
  }
</script>

<style scoped>
</style>
