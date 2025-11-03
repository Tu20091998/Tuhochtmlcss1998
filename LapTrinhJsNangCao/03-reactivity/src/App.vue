<script setup>
  import { nextTick, ref } from 'vue'

  const count = ref(0);

  const increase = async () =>{
    count.value++
    await nextTick();
    console.log(document.getElementById('count').innerText)
  }
</script>

<template>
  <div>
    <p id="count">Count: {{ count }}</p>
    <button @click="increase">Nhấn để tăng</button>
  </div>
</template>
