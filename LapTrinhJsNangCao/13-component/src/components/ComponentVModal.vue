<template>
    <div>
        <label for="Email">Email</label>
        <input type="text" v-model="email"/>
        <p>{{ email }}</p>

        <button @click="setEmailDefault">Nhấn để đổi nội dung</button>
    </div>
</template>

<script setup>
    import { ref } from 'vue';

    const email = defineModel();

    const setEmailDefault = () =>{
        email.value = "Tú đẹp trai !";
    }
</script>