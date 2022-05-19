<template>
  <div>
    <!-- <img alt="Vue logo" src="./assets/logo.png" /> -->
    <!-- 1st Version: Toggle and untoggle buttons-->
    <!-- <TestComponent /> -->

    <!-- 2nd version: Forms-->
    <!-- <SignUpForm /> -->

    <!-- 3rd Version: Routers -->
    <router-link style="margin: 20px" to="/">Home</router-link>
    <router-link style="margin: 20px" to="/about">About</router-link>
    <!-- Do the binding with the value defined on route based on name -->
    <!-- This is a better practice, since you don't need to rewrite the path in different places -->
    <router-link style="margin: 20px" :to="{name: 'Products'}">Products</router-link>
    <router-link style="margin: 20px" :to="{name: 'SignUp'}">Sign Up</router-link>
    
    <router-view />
  </div>
</template>

<script>
// import TestComponent from "./components/TestComponent.vue";

// We don't need to put .vue at the end of the file
import SignUpForm from "./components/SignUpForm";
export default {
  name: "App",
  components: {
    // TestComponent,
    SignUpForm,
  },
};
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
