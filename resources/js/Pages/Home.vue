<template>
    <main-layout :navItems="navItems">
        <slot></slot>
    </main-layout>
</template>

<script>
import MainLayout from '@/Layouts/MainLayout.vue';

export default{
    name: 'HomePage',
    components: {
      MainLayout,
    },
    props: {
        navItems: {
        type: Array,
        required: true
        }
    }
};
</script>