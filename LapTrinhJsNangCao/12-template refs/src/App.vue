<script setup>
  import { onMounted, ref} from 'vue';
  
  const inputRef = ref(null);
  
  const list = ref(["item 1", "item 2", "item 3"]);

  const itemRef = ref([]);

  onMounted(() =>{
    inputRef.value.focus();

    itemRef.value.forEach((item) =>{
      item.style.transition = "opacity 10s";
      item.style.opacity = 1;
    })
  });
  
</script>

<template>
  <div>
    <h1>Template refs</h1>
    <input ref="inputRef">

    <ul>
      <li v-for="(item, index) in list" :key="index" ref="itemRef" style="opacity: 0;">{{ item }}</li>
    </ul>
  </div>
</template>

