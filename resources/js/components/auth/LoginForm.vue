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
                <button type="submit" class="bg-teal-500 hover:bg-teal-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">
                    Sign in
                </button>
            </div>
            <hr/>
            <div class="form-group">
                <label for="name" class="col-md-4 text-center control-label">Social Login</label>
                <div class="col-md-6">
                    <a href="/login/facebook" class="btn bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">
                          FaceBook
                    </a>
                    <!--a href="/login/twitter" class="btn btn-social-icon btn-twitter"></a-->
                    <!--a href="/login/google" class="btn btn-social-icon btn-google-plus"></a-->
                    <!--a href="/login/linkedin" class="btn btn-social-icon btn-linkedin"></a-->
                    <a href="/login/github" class="btn bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">
                          Github
                    </a>
                </div>
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
.btn{
  display: block;
  text-align: center;
  margin-bottom: 10px;
}
</style>
