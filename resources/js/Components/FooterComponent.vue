<template>
  <footer>
    <p> {{ currentTime }}</p>
  </footer>
</template>

<script setup>
  import { onBeforeUnmount, onMounted, ref } from 'vue';
  defineOptions({
    name: 'FooterComponent',
  })

  const getCurrentTime = () =>{
    return new Date().toLocaleString();
  };
  const currentTime = ref(getCurrentTime());

  let timer = null;
  onMounted(()=>{
    timer = setInterval(() => {
      currentTime.value = getCurrentTime();
    }, 1000); // 每秒更新时间
  });

  onBeforeUnmount(()=>{
    clearInterval(timer);
  });
</script>

<style scoped>
footer {
  text-align: right;
  padding: 10px;
  
}
p{
  margin-top: -0.5%;
}
</style>
