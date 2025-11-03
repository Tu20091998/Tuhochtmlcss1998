<script setup>
  import {computed, reactive, ref} from 'vue'

  const count = ref(0);

  const book = reactive({
    name: "Nhà giả kim",
    chapter:[]
  })

  const addChapter = () =>{
    book.chapter.push("Chapter 1")
  }

  const editName = () =>{
    book.name = "Đắc nhân tâm";
  }

  const isPublish = computed(() =>{
    return book.chapter.length ? "Đã xuất bản" : "Xuất bản cái nịt" 
  });
</script>

<template>
  <div>
    <p id="book">{{ book.name }}</p>
    <p id="book">{{ isPublish }}</p>
    <button @click="addChapter">Thêm chapter</button>
    <button @click="editName">Đổi tên sách </button>
  </div>
</template>
