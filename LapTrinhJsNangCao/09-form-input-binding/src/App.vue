<script setup>
  import { computed, reactive, ref } from 'vue';
  
  const text = ref()
  const textArea = ref("Input your message !")

  const checkedName = ref([])

  const checked = ref()

  const radioChecked = ref()

  const Selected = ref()

  const firstOption = ref("first option")

  const secondOption = ref("second option")
</script>

<template>
  <div>
    <h1>Form Input Bindings</h1>
    <input v-model="text">
    <p>Text: {{ text }} {{ typeof text }}</p>

    <br></br>
    <p>Check: {{ checked }}</p>
    <label for="@">True & False Checkbox</label>
    <input type="checkbox" id="@" v-model="checked" true-value="yes" false-value="no">

    <p>CheckBox: {{ checkedName }}</p>
    <label for="a">A:</label>
    <input type="checkbox" id="a" v-model="checkedName" :value="firstOption">

    <label for="b">B:</label>
    <input type="checkbox" id="b" v-model="checkedName" :value="secondOption">

    <p>Radio: {{ radioChecked }}</p>
    <label for="a">A: </label>
    <input type="radio" id="a" v-model="radioChecked" value="A">

    <label for="b">B: </label>
    <input type="radio" id="b" v-model="radioChecked" value="B">

    <p>Select: {{ Selected }}</p>
    <label for="selectABC">Select:</label>
    <select v-model="Selected" id="selectABC">
      <option disabled value="">Please select one</option>
      <option :value="{name : 'a'}">A</option>
      <option :value="[1,2,3,4,5]">B</option>
      <option>C</option>
    </select>
  </div>
</template>

