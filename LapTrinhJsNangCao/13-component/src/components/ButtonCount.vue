<template>
    <div>
        <button @click="callFuntionIncrease">Increase</button>
        <button @click="callFuntionIncreaseByTwoTime">IncreaseByTwoTime</button>
        <button @click="callFuntionIncreaseBy">IncreaseBy</button>
    </div>
</template>

<script setup>
    const emit = defineEmits(["increase", "increaseByTwoTime", "increaseBy"])

    const callFuntionIncrease = () =>{
        emit("increase");
    }

    const callFuntionIncreaseByTwoTime = () =>{
        emit("increaseByTwoTime");
    }

    const callFuntionIncreaseBy = () =>{
        emit("increaseBy",5,5);
    }
</script>