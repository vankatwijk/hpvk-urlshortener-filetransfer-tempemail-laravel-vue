<template>
    <div class="rounded text-gray-600 bg-white p-6 shadow w-full">
        <p class="font-semibold">
            <slot name="title"></slot>
        </p>

        <div class="mt-2"></div>

        <slot name="body"></slot>
    </div>
</template>

<script>
  export default {
    name: 'Notification'
  }
</script>

<style scoped>

</style>
