<template>
    <div class="flex flex-col sm:flex-row mx-auto justify-between focus:outline-none border border-transparent sm:focus-within:border-teal-500 rounded-full">
        <input v-model="original" type="text" class="p-3 pl-5 w-full sm:w-10/12 z-10 text-teal-600 outline-none rounded-l-full rounded-r-full sm:rounded-r-none"
               required
               autocorrect="off" autocapitalize="none"
               @keyup.enter="shorten()"
               placeholder="Enter URL / Upload file">
        <button
            onclick="document.getElementById('file').click();"
            @submit.prevent=""
            class="w-full sm:w-6/12 bg-teal-800 hover:bg-teal-400 text-white font-bold py-3 px-4 z-0 mt-2 sm:mt-0 sm:-ml-5 rounded-full sm:rounded-r-none focus:outline-none">
            <span v-if="! isLoading" class="sm:ml-5 text-lg">Upload</span>

        </button>
        <button
            @submit.prevent=""
            @click.prevent="shorten()"
            type="submit"
            class="w-full sm:w-6/12 bg-teal-500 hover:bg-teal-600 text-white font-bold py-3 px-4 z-0 mt-2 sm:mt-0 sm:-ml-5 rounded-full focus:outline-none">
            <span v-if="! isLoading" class="sm:ml-5 text-lg">Shorten</span>
            <span>
                <clip-loader :loading="isLoading" :color="'#5dc596'" :size="'20px'" class="mx-auto sm:ml-5"></clip-loader>
            </span>
        </button>
        <input @change="upload" type="file" style="display:none;" id="file" name="file"/>
    </div>
</template>

<script>
  import linksClient from '../../api/links'

  export default {
    name: 'ShortenLinkForm',

    data () {
      return {
        isLoading: false,
        original: '',
      }
    },

    methods: {
      async upload(e) {

        var files = e.target.files || e.dataTransfer.files;
        if (!files.length){
          return;

        }else{
          console.log('file has size');
          this.isLoading = true;
          this.file = e.target.files[0];

          const link = {
            original: '@file',
            file:  this.file
          }

          try {
            const response = await linksClient.upload(link)
            this.original = ''
            this.$emit('addToPreviousLinks', response.data)
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
      
      async shorten () {
        this.isLoading = true

        const link = {
          original: this.addProtocolToLink(this.original)
        }

        try {
          const response = await linksClient.shorten(link)
          this.original = ''
          this.$emit('addToPreviousLinks', response.data)
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
      },

      addProtocolToLink (link) {
        if (link.substring(0, 8) !== 'https://' && link.substring(0, 7) !== 'http://') {
          link = 'https://' + link
        }

        return link
      }
    },
  }
</script>

<style scoped>
</style>
