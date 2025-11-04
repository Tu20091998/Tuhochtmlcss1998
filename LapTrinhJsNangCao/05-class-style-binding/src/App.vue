<script setup>
  import { computed, reactive, ref } from 'vue';
  const color = ref('red')
  const background = ref('blue')
  const fontSize = ref(30)

  const styleObject = reactive({
    border:'none',
    borderRadius: '6px'
  })

</script>

<template>
  <div>
    <button
      :style="[{
        color,
        background,
        fontSize: fontSize + 'px',
      },styleObject]"
    >
      button
    </button><br></br>

  </div>
</template>

