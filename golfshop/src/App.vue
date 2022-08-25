<template>
  <header>
    <div id="logo">
        <h1>Golf Shop</h1>
    </div>
    <nav>
      <ul id="topMenu">
        <li><router-link style="margin: 20px" to="/products">Products</router-link></li>
        <li><router-link style="margin: 20px" to="/shoppingcart"
      >Shopping Cart</router-link
    ></li>
        <li> <router-link style="margin: 20px" to="/orders">Orders</router-link></li>
        <li
      v-if="!$store.getters.getIsLogin"
      class="sign up"
      style="display: inline"
    >
      <router-link style="margin: 20px" to="/sign">Sign Up</router-link>
    </li>
    <li v-else class="account" style="display: inline">
      <router-link style="margin: 20px" to="/account"
        >{{ $store.getters.getCurrentUser.name }}'s Account</router-link
      >
    </li>
      </ul>
    </nav>
     <router-view />
  </header>
 
</template>

<script>
import SignUpForm from "./components/SignUpForm";
export default {
  name: "App",
  components: {
    SignUpForm,
  },
  data() {
    return {};
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



nav {
  width: 100%;
  height: 80px;
  background-color: #058C42;
}

ul {
  list-style: none;
}

#topMenu {
  height: 60px;
  display: flex;
  flex-direction: row;
  justify-content: space-evenly;
}

#topMenu > li > a {
  display: block;
  color: white;
  font-weight: 600;
  font-size: 16px;
  padding: 20px 100px 20px 100px;
}

#topMenu > li > a:hover {
  color: whitesmoke;
}

#topMenu > li > ul {
  display: none;
  position: absolute;
  width: 150px;
  background-color: rgba(255, 255, 255, 0.9);
  left: 20px;
  margin: 0;
}


</style>
