<template>
  <nav class="navbar">
    <ul>
      <li v-for="item in navItems" :key="item.link">
        <a :href="item.link">{{ item.name }}</a>
      </li>
    </ul>
  </nav>
</template>

<script setup>
  defineOptions({
    name: 'NavBar',
  });

  const props = defineProps({
    navItems: {
      type: Array,
      required: true
    }
  });

</script>

<style scoped>
.navbar {
  background-color: #92B598;
  overflow: hidden;
}

.navbar ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
}

.navbar li {
  float: left;
}

.navbar li a {
  display: block;
  color: white;
  text-align: center;
  padding: 3px 10px;
  text-decoration: none;
}

.navbar li a:hover {
  background-color: #E9F1EA;
  color: black;
}
</style>
