<template>
    <div>
        <transition appear name="fade" mode="out-in">
          <div class="">

            <img v-if="!user.avatar" class="flex md:w-1/12 p-2 mb-6 mx-auto shadow rounded-full" src="https://upload.wikimedia.org/wikipedia/commons/7/7c/Profile_avatar_placeholder_large.png" alt="Profile image"/>
            <img v-if="user.avatar" class="flex md:w-1/12 p-2 mb-6 mx-auto shadow rounded-full" :src="APP_URL+'/storage/'+user.avatar" alt="Profile image"/>
            
            <span class="flex md:w-4/12 p-2 mb-6 mx-auto shadow rounded-full">
              <a :href="APP_URL+'/tree/'+treeLink" class="text-blue-500 hover:underline">{{APP_URL+'/tree/'+treeLink}}</a>
            </span>
          </div>

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
                <template #list-title>links</template>
                <template #list-item="{ link, selected }">
                    <basic-links-list-item :link="link" :selected="selected" @UpdateLinks="UpdateLinks"></basic-links-list-item>
                </template>
            </links-list>
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
