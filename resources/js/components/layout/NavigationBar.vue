<template>
    <nav class="bg-black text-white shadow py-4 px-4 sm:flex sm:justify-between sm:items-baseline">
        <div class="flex justify-between items-baseline">
            <a :href="'/'" class="text-white font-semibold subpixel-antialiased text-xl">HPVK</a>
            <div class="sm:hidden">
                <button @click="isOpen = !isOpen" type="button" class="block text-gray-500 hover:text-teal-700 focus:outline-none">
                    <svg class="h-6 w-6 fill-current" viewBox="0 0 24 24" alignment-baseline="bottom">
                        <path v-if="isOpen" fill-rule="evenodd"
                              d="M18.278 16.864a1 1 0 0 1-1.414 1.414l-4.829-4.828-4.828 4.828a1 1 0 0 1-1.414-1.414l4.828-4.829-4.828-4.828a1 1 0 0 1 1.414-1.414l4.829 4.828 4.828-4.828a1 1 0 1 1 1.414 1.414l-4.828 4.829 4.828 4.828z"/>
                        <path v-if="!isOpen" fill-rule="evenodd" d="M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z"/>
                    </svg>
                </button>
            </div>
        </div>
        <div :class="isOpen ? 'inline-block' : 'hidden'" class="sm:flex mt-3 md:mt-0">
            <a v-if="!this.user" :href="'/login'" class="block hover:text-teal-700 py-1 sm:py-0 sm:ml-5">Login</a>
            <a v-if="!this.user" :href="'/register'" class="block hover:text-teal-700 py-1 sm:py-0 sm:ml-5">Register</a>

            <a v-if="this.user" :href="'/tree'" class="block hover:text-teal-700 py-1 sm:py-0 sm:ml-5">Link Tree</a>
            <a v-if="this.user" :href="'/home'" class="block hover:text-teal-700 py-1 sm:py-0 sm:ml-5">Home</a>
            <a v-if="this.user" :href="'/logout'" class="block hover:text-teal-700 py-1 sm:py-0 sm:ml-5">Logout</a>
        </div>
    </nav>
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
