<template>
    <div class="container flex">
        <form action="/register" method="POST" class="max-w-sm w-full md:max-w-md bg-white mx-auto shadow rounded px-8 pt-6 pb-8 mb-4">
            <input type="hidden" name="_token" :value="csrfToken">

            <h1 class="text-lg text-center text-gray-700 font-semibold subpixel-antialiased mb-4">Let's Get You Signed Up!</h1>
            <div class="mb-4">
                <label for="username" class="block text-gray-700 text-sm
                    font-bold mb-2">
                    Username
                </label>
                <input required type="text" id="username" name="username" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray">
                <small v-if="errors.username" class="text-red-800 font-semibold">
                    {{ errors.username[0] }}
                </small>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm
                    font-bold mb-2">
                    Email
                </label>
                <input required type="email" id="email" name="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray">
                <small v-if="errors.email" class="text-red-800 font-semibold">
                    {{ errors.email[0] }}
                </small>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm
                    font-bold mb-2">
                    Password
                </label>
                <input required type="password" id="password" name="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray">
                <small v-if="errors.password && errors.password[0] !== 'The password confirmation does not match.'" class="text-red-800 font-semibold">
                    {{ errors.password[0] }}
                </small>
            </div>
            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm
                    font-bold mb-2">
                    Confirm Password
                </label>
                <input required type="password" id="password-confirm" name="password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray">
                <small v-if="errors.password && errors.password[0] === 'The password confirmation does not match.'" class="text-red-800 font-semibold">
                    {{ errors.password[0] }}
                </small>
            </div>

            <div class="flex items-center">
                <button type="submit" class="bg-teal-500 hover:bg-teal-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">
                    Register
                </button>
            </div>
        </form>

    </div>
</template>

<script>
  export default {
    name: 'RegisterForm',

    props: ['errors'],

    data () {
      return {
        csrfToken: null,
      }
    },

    created () {
      this.csrfToken = document.querySelector('meta[name="csrf-token"]').content
    }
  }
</script>

<style scoped>

</style>
