<template>
  <ul class="flex flex-col items-center">
      <li>
        <a class="bg-white inline-block py-2 px-4 text-blue-500 hover:text-blue-800 font-semibold ml-10" href="#">Shorten Links</a>
        <a class="bg-white inline-block py-2 px-4 text-blue-500 hover:text-blue-800 font-semibold" href="#">Link Tree</a>
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
