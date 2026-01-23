<template>
    <div>
        <label for="Email">Email</label>
        <input type="text" v-model="email"/>
        <p>{{ email }}</p>

        <button @click="setEmailDefault">Nhấn để đổi email</button>
    </div>

    <div>
        <label for="UserName">UserName</label>
        <input type="text" v-model="username"/>
        <p>{{ username }}</p>

        <button @click="setUsernameDefault">Nhấn để đổi tên</button>
    </div>
</template>

<script setup>
    const email = defineModel("email");
    const username = defineModel("username");

    const setEmailDefault = () =>{
        email.value = "Tú đẹp trai@gmail.com !";
    }

    const setUsernameDefault = () =>{
        username.value = "Tú đẹp trai !";
    }
</script>