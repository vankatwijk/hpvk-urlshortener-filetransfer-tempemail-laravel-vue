<template>
  <ul class="flex">
    <li class="mr-6">
      <a class="text-blue-500 hover:text-blue-800" href="#">Shorten Links</a>
    </li>
    <li class="mr-6">
      <a class="text-blue-500 hover:text-blue-800" href="#">Link Tree</a>
    </li>
  </ul>
</template>

<script>
  export default {
    name: 'navigation-bar',

    props: ['user'],

    data () {
      return {
        APP_URL: process.env.MIX_APP_URL,
        isOpen: false,
      }
    },
  }
</script>

<style scoped>

</style>
