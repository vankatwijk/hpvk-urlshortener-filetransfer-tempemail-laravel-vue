<template>
    <div>
        <p class="uppercase font-semibold text-gray-600">
            <slot name="list-title"></slot>
        </p>
        <transition-group name="list" tag="ul">
            <li v-for="link in links" :key="link.id" @click="select(link.id)">
                <slot name="list-item" :link="link" :selected="isSelected(link.id)"></slot>
            </li>
        </transition-group>
    </div>
</template>

<script>
  export default {
    name: 'LinksList',

    props: ['links'],

    data () {
      return {
        selectedId: 0,
      }
    },

    methods: {
      select (id) {
        let link = this.links.find(link => link.id === id)

        if (link) {
          this.selectedId = link.id
          this.$emit('input', link)
        }
      },
      isSelected (id) {
        return this.selectedId === id
      },
    },

    mounted () {
      this.select(this.links[0].id)
    }
  }
</script>

<style scoped>
</style>
