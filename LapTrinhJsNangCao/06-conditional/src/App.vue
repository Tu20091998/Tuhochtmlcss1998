<script setup>
  import { computed, reactive, ref } from 'vue';
  const isLoggerIn = ref(true);

  const toggleLoggerIn = () =>{
    isLoggerIn.value = !isLoggerIn.value
  }

  const userStatus = ref('online');

  const changeStatus = () =>{
    if(userStatus.value === 'online'){
      userStatus.value = 'away'
    }else if(userStatus.value === 'away'){
      userStatus.value = 'busy'
    }else if(userStatus.value === 'busy'){
      userStatus.value = 'online'
    }
  }

  const isVisible = ref(true);

  const toggleShow = () =>{
    isVisible.value = !isVisible.value
  }

</script>

<template>
  <div>
    <h1 v-if="isLoggerIn">Chào mừng người dùng đã đăng nhập</h1>
    <h1 v-else>Chào mừng Khách vãng lai</h1>
    <button @click="toggleLoggerIn">{{ isLoggerIn ? 'Đăng xuất' : 'Đăng nhập' }}</button>
    <br></br>

    <h1 v-if="userStatus === 'online'">Người dùng đang online</h1>
    <h1 v-else-if="userStatus === 'away'">Người dùng đang vắng mặt</h1>
    <h1 v-else-if="userStatus === 'busy'">Người dùng đang bận</h1>
    <h1 v-else>Không rõ trạng thái</h1>
    <button @click="changeStatus">Thay đổi trạng thái của người dùng</button>
    <br></br>

    <h1 v-show="isVisible">Nội dung này ẩn hoặc hiện thị</h1>
    <button @click="toggleShow">{{ isVisible ? 'Ẩn' : 'Hiện' }}</button>
  </div>
</template>

