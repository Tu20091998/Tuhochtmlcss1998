<script setup>
  const Message = "Hello world !!! Tú đẹp trai";
  const rawHtml = '<div><h1>Đây là ai !</h1></div><span style="color: red">This should be red.</span>';
  const dynamicId = "ButtonId";
  const dynamicClass = "ButtonClass";
  const isButtonDisabled = false;
  const objectOfAttrs = {
    id: 'container',
    class: 'wrapper',
    style:{
      color: 'blue'
    }
  }
  const number = 2;
  const listString = 'a,b,c,d,e,f,g,h,j';
  const convertToId = (data) => data.split(',').reverse().join('-');

  const attributeName = "href";
  const url = "http://ap.poly.edu.vn"
</script>

<template>
  <h1>Syntax</h1>
  <p>Message: {{ Message }}</p>
  <span v-html="rawHtml"></span><br></br>
  <button :id="dynamicId" :class="dynamicClass" :disabled="isButtonDisabled">{{ isButtonDisabled ? 'Disabled': 'Click here !' }}</button><br></br>
  <button v-bind="objectOfAttrs">Click vào đây để hiện object !</button>
  <button :id="convertToId(listString)">Number: {{ number*2 }}</button><br></br>
  <a v-bind:[attributeName] = "url">Nhấn vào đây để truy cập link !</a>
</template>
