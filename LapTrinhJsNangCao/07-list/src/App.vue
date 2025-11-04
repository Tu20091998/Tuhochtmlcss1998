<script setup>
  import { computed, reactive, ref } from 'vue';
  //phần tử trong object chứa trong mảng
  const shoppingItems = ref([
    {
      name: "orange",
      price: 10,
      isActive: true
    },
    {
      name: "apple",
      price: 12,
      isActive: true
    },
    {
      name: "banana",
      price: 18,
      isActive: true
    }
  ])

  //phần tử trong object
  const user = ref(
    {
      firstName: "Tú",
      lastName: "Nguyễn",
      age: 27
    }
  )

</script>

<template>
  <div>
    <!--//phần tử trong object chứa trong mảng-->
    <ul>
      <template v-for="(item,index) in shoppingItems">
        <li v-if="item.isActive" :key="item.name">
          {{ item.name }} - {{ item.price }} : {{ item.isActive ? 'Active' : 'Deactive' }} - {{ index }}
        </li>
      </template>
    </ul>

    <span v-for="n in 10" :key="n">{{ n }}</span>

    <!--//phần tử trong object-->
    <ul>
      <li v-for="(value, key, index) in user" :key="key">
        {{ key }}: {{ value }} - {{ index }}
      </li>
    </ul>
  </div>
</template>

