<script setup>
  import {computed, reactive, ref} from 'vue'

  const firstName = ref('Nguyễn Đình');

  const lastName = ref('Tú');

  const fullName = computed({
    get(){
      return firstName.value + ' ' + lastName.value
    },

    set(newValue){
      [firstName.value, lastName.value] = newValue.split(',')
    }
  });

  const changeFullName = () =>{
    fullName.value = 'Nguyễn Đình,Thao'
  }
</script>

<template>
  <div>
    <p id="book">Full name:{{ fullName }}</p>
    <p id="book">Full name:{{ firstName }}</p>
    <p id="book">Full name:{{ lastName }}</p>
    <button @click="changeFullName">changeFullname</button>
  </div>
</template>
