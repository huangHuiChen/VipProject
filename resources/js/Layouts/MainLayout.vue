<template>
  <div id="layout">
    <header-component :navItems="navItems"></header-component>
    <br>
    <main>
      <slot></slot>
    </main>
    <footer-component></footer-component>
  </div>
</template>

<script setup>
import HeaderComponent from '@/Components/HeaderComponent.vue';
import FooterComponent from '@/Components/FooterComponent.vue';

defineOptions({
  name: 'MainLayout',
});

const props = defineProps({
  navItems: {
      type: Array,
      required: true
    }
});
</script>

<style scoped>
#layout {
  width: 100%;
  height:100%;
}

main{
  height: 75%;
}
</style>