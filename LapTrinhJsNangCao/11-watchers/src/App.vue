<script setup>
  import { computed, reactive, ref, watch, watchEffect } from 'vue';
  
  const x = ref(0);
  const y = ref(0);

  const user = reactive({
    age: 18,
    class:{
      students: 0,
      name: "A"
    }
  })

  watchEffect(() =>{
    console.log(`Giá trị của x là ${x.value} và y là ${y.value}`);
  })

  watchEffect(() =>{
    console.log(`User: ${JSON.stringify(user)}`);
  })

  // watch(user, (newUser, oldUser)=>{
  //   console.log(`User:  ${JSON.stringify(newUser)} ${JSON.stringify(oldUser)}`);
  // },{deep: true, immediate:true});

  const changeAge = () =>{
    user.class.students++;
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

