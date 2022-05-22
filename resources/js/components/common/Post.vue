<template>

  <div class="max-w-sm rounded overflow-hidden shadow-lg">
    <img class="w-full" :src="post.img" alt="Sunset in the mountains">
    <div class="px-6 py-4">
      <div class="text-gray-600 font-bold text-xl mb-2">{{post.title}}</div>
      <p class="text-gray-600 text-base">
        {{post.body}}
      </p>
    </div>
    <div class="px-6 py-4">
      <span class="inline-block bg-grey-lighter rounded-full px-3 py-1 text-sm font-semibold text-gray-400 mr-2">{{post.tag1}}</span>
      <span class="inline-block bg-grey-lighter rounded-full px-3 py-1 text-sm font-semibold text-gray-400 mr-2">{{post.tag2}}</span>
      <span class="inline-block bg-grey-lighter rounded-full px-3 py-1 text-sm font-semibold text-gray-400">{{post.tag3}}</span>
    </div>
  </div>

</template>

<script>
  export default {
    name: 'post',

    props: ['post'],

    data () {
      return {
      }
    },
  }
</script>

<style scoped>
</style>
