<script setup>
  import { computed, reactive, ref } from 'vue';
  //phần tử trong object chứa trong mảng
  const todos = reactive([
    {
      id: 1,
      text: 'Learn Vue',
    },
    {
      id: 2,
      text: 'Learn JavaScript',
    },
    {
      id: 3,
      text: 'Learn TypeScript',
    }
  ])

  const newTodo = ref();

  const addTodo = () =>{
    if(newTodo.value.trim() === "") return

    const todo = {
      id: todos.length + 1,
      text: newTodo.value,
    }

    todos.push(todo);
    newTodo.value = "";
  }

</script>

<template>
  <div>
    <input type="text" v-model="newTodo" @keyup.enter="addTodo">
    <button @click="addTodo">Add Todo</button>
    <ul>
        <li v-for="todo in todos" :key="todo.id">
          {{ todo.id }} - {{ todo.text }}
        </li>
    </ul>
  </div>
</template>

