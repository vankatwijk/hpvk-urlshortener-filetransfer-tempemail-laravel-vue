<template>
    <div class="p-3">
        <transition appear name="fade">
            <shorten-link-form @addToPreviousLinks="addToPreviousLinks" class="sm:w-full md:w-2/3"></shorten-link-form>
        </transition>

        <transition appear name="fade" mode="out-in">
            <links-list :links="previousLinks" v-if="previousLinks.length > 0" class="rounded mt-10 bg-white p-6 shadow w-full md:w-2/3 mx-auto">
                <template #list-title>Links</template>
                <template #list-item="{ link, selected }">
                    <previous-links-list-item :link="link" :selected="selected"></previous-links-list-item>
                </template>
            </links-list>

            <div v-if="previousLinks.length === 0" class="md:w-2/3 mt-10 mx-auto">
                <notification>
                    <template #title>Hey! HPVK.com is the Swiss army knife of tiny web tools.</template>
                    <template #body>
                        <p>This feels empty...</p><br/>
                        <p>Start by adding some links or upload a file to transfer(48hrs) with our tiny url👆</p>
                        <p>Then view your dashboard for some amazing insights <span>📈</span></p>
                        <p>Also try our Link tree form the dashboard <span>🌳</span></p>
                    </template>
                </notification>
            </div>
        </transition>

        <div class="flex flex-row text-gray-600 justify-center mt-12">
            <a href="https://github.com/vankatwijk/hpvk-urlshortener-filetransfer-tempemail-laravel-vue">View the code on <i class="fab fa-github"></i></a>
        </div>

        <div class="flex flex-row text-gray-600 justify-center mt-12">
            <a class="bmc-button" target="_blank" href="https://www.buymeacoffee.com/hendrikus">
              <link href="https://fonts.googleapis.com/css?family=Cookie" rel="stylesheet">
              <img src="https://www.buymeacoffee.com/assets/img/BMC-btn-logo.svg" alt="Buy me a coffee">
              <span style="margin-left:5px">Buy me a coffee</span>
            </a>
        </div>
    </div>
</template>

<script>
  export default {
    name: 'ShortenLinkPage',

    data () {
      return {
        previousLinks: [],
      }
    },

    methods: {
      addToPreviousLinks (link) {
        if (this.previousLinks.length >= 3) {
          this.previousLinks.splice(-1)
        }

        this.previousLinks.unshift(link)
      },
    }
  }
</script>

<style scoped>
.bmc-button>span {
  font-family:'Cookie', cursive !important;
}
.bmc-button img {
  width: 27px !important;
  margin-bottom: 1px !important;
  box-shadow: none !important;
  order: none !important;
  vertical-align: middle !important;
  }.bmc-button{line-height: 36px !important;
  height:37px !important;
  text-decoration: none !important;
  display:inline-flex !important;
  color:#333333 !important;
  background-color:#FFDD00 !important;
  border-radius: 3px !important;
  border: 1px solid transparent !important;
  padding: 1px 9px !important;
  font-size: 23px !important;
  letter-spacing:0.6px !important;
  box-shadow: 0px 1px 2px rgba(190, 190, 190, 0.5) !important;
  -webkit-box-shadow: 0px 1px 2px 2px rgba(190, 190, 190, 0.5) !important;
  margin: 0 auto !important;
  -webkit-box-sizing: border-box !important;
  box-sizing: border-box !important;
  -o-transition: 0.3s all linear !important;
  -webkit-transition: 0.3s all linear !important;
  -moz-transition: 0.3s all linear !important;
  -ms-transition: 0.3s all linear !important;
  transition: 0.3s all linear !important;
}
.bmc-button:hover, .bmc-button:active, .bmc-button:focus {
  -webkit-box-shadow: 0px 1px 2px 2px rgba(190, 190, 190, 0.5) !important;
  text-decoration: none !important;
  box-shadow: 0px 1px 2px 2px rgba(190, 190, 190, 0.5) !important;
  opacity: 0.85 !important;
  color:#555555 !important;
}
</style>
