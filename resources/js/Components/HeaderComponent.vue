<template>
  <header>
    <div class="header_images">
    </div>
    <nav-bar :navItems="navItems"></nav-bar>
  </header>
</template>

<script setup>
  import NavBar from './NavBar.vue';

  defineOptions({
    name: 'Header',
  });

  const props = defineProps({
    navItems: {
        type: Array, 
        required: true
      }
  });
</script>

<style scoped>
.header_images {
 height: 75%;
}

</style>
