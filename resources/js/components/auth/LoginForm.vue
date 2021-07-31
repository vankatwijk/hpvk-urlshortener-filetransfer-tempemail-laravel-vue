<template>
    <div class="container flex">
        <form action="/login" method="POST" class="max-w-sm w-full md:max-w-md bg-white mx-auto shadow rounded px-8 pt-6 pb-8 mb-4">
            <input type="hidden" name="_token" :value="csrfToken">

            <h1 class="text-lg text-center text-gray-700 font-semibold subpixel-antialiased mb-4">Welcome Back!</h1>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm
                    font-bold mb-2">
                    Email
                </label>
                <input required type="email" id="email" name="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray">
                <small v-if="errors.email" class="text-red-800 font-semibold">{{ errors.email[0] }}</small>
            </div>
            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm
                    font-bold mb-2">
                    Password
                </label>
                <input required type="password" id="password" name="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray">
                <small v-if="errors.password" class="text-red-800 font-semibold">{{ errors.password[0] }}</small>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-purple-500 hover:bg-purple-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">
                    Sign in
                </button>
            </div>
        </form>

    </div>
</template>

<script>
  export default {
    name: 'LoginForm',

    props: ['errors'],

    data() {
      return {
        csrfToken : null,
      }
    },

    created() {
      this.csrfToken = document.querySelector('meta[name="csrf-token"]').content
    }
  }
</script>

<style scoped>

</style>
