<script setup>
  import { computed, reactive, ref } from 'vue';
  
  const count = ref(0);

  const greet = (event) =>{
    console.log(event.target);
    alert(`xin chào ${event}`);
  }

  const sayHi = (name,event) =>{
    console.log(event.target);
    alert(`Xin chào ${name}`)
  }

  const sayHi1 = (name) =>{
    alert(`Xin chào ${name}`)
  }

  const sayHi2 = (name) =>{
    console.log(name);
    alert(`Xin chào ${name}`)
  }

  const submit = () =>{
    alert('Form submitted');
  }

</script>

<template>
  <div>
    <h1>Event handling</h1>
    <p>{{ count }}</p>
    <button @click="count++">Thêm 1</button>

    <button @click="greet">Chào</button>

    <button @click="sayHi1('Tú')"><button @click.self="sayHi2('Trường')">Chào Trường</button>
      Chào Tú
    </button>
    

    <form @submit.prevent.stop="submit">
      <button type="submit">Submit</button>
    </form>
    <br></br>

    <!--Key modifier khi xử lý event trong Vuejs-->
    <input @keyup.shift="submit" placeholder="Nhập gì đó !">
    <button @click.shift="submit">Submit</button>
  </div>
</template>

