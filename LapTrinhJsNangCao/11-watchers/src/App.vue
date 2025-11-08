<script setup>
  import { computed, reactive, ref, watch } from 'vue';
  
  const x = ref(0);
  const y = ref(0);

  const user = reactive({
    age: 18
  })

  watch(() => x.value + y.value, (sum) =>{
    console.log(`Tổng của x và y là: ${sum}`);
  })

  watch([x, () => y.value + 1], ([newX, newY])=>{
    console.log(`Giá trị cập nhật là ${newX} và ${newY}`);
  })

  watch(()=>user.age, (newAge)=>{
    console.log(`Tuổi được cập nhật là ${newAge}`);
  })

  const changeAge = () =>{
    user.age = 20;
  }

  const increment = () =>{
    x.value++;
    y.value++;

  }
</script>

<template>
  <div>
    <h1>Watchers</h1>
    <p>{{ x }}, {{ y }}</p>
    <button @click="increment">Increment</button>

    <p>{{ user.age }}</p>
    <button @click="changeAge">ChangeAge</button>
  </div>
</template>

