<template>
  <div class="test">
    <!-- Here we are saying that the text-success will be activated only when property isSuccess is true -->
    <h1 :class="{'text-success': isSuccess}">This is a test Component, Do all your tests here</h1>

    <!-- :class means that you are biding this class to a certain value -->
    <!-- This element will have active and text-danger classes only if the properties are true -->
    <div class="static" :class="{ active: isActive, 'text-danger': hasError }">
      This is a binding Example
    </div>

    <!-- This is only for test purposes, to check the variables values -->
    <p>  isActive {{isActive}} </p>
    <p>  hasError {{hasError}} </p>
    <p>  isSuccess {{isSuccess}} </p>

    <!-- v-onclick = @click -->
    <!-- When inside the click, you just need to pass the name of the method, without () -->
    <button @click="toggleActive" style="margin: 20px">toggle active class</button>
    <button @click="toggleHasError">text-danger class</button>
    <button @click="toggleIsSuccess" style="margin: 20px">turn to green</button>
    <h4 v-if="isPerfect">Everything is perfect</h4>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isActive: true,
      hasError: false,
      isSuccess: false,
    };
  },

  methods: {
    toggleActive() {
      this.isActive = !this.isActive;
    },

    toggleHasError() {
      this.hasError = !this.hasError;
    },

    toggleIsSuccess(){
      this.isSuccess = !this.isSuccess;
    }
  },

  // this is automatically called
  // this is a lifecycle method
  mounted() {
    setTimeout(() => (this.hasError = true), 4000);
  },

  // This is created as a function, but when used, you use as a variable
  // This is almost like "data" section
  computed: {
    isPerfect() {
      return this.isActive && !this.hasError;
    },
  },
};
</script>

<style scoped>
.static{
  background-color: lightgray;
}

.test {
  width: 80%;
  margin: auto;
  border: 2px solid black;
  padding: 20px;
  font-size: 20px;
}

.active {
  font-size: 30px;
}

.text-danger {
  color: red;
}

.text-success{
  color: green;
}
</style>
