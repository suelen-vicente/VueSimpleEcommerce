<template>
  <h1>Our Products</h1>
  <div style="display:flex">
      <div class="product" v-for="p in products" :key="p.id">
          <!-- router-link is used instead of a href -->
          <router-link :to="{name: 'ProductDetails', params:{id: p.id}}"> <h4>{{p.name}}</h4> </router-link>
          <p>{{p.price}}</p>
          <p>{{p.size}}</p>
          <!-- This button is not looking like a button, don't know what is happening. Fix it later! -->
          <button @click="addToCart(p.name)" style="margin-bottom: 20px">Add to cart</button>
      </div>
  </div>
  <br>
  {{$store.getters.getCart}}
</template>

<script>
export default {
    data(){
        return{
            products: []
        }
    },

    mounted(){
        // this.$store access all store methods
        this.products = this.$store.getters.getProducts
    },

    methods: {
        addToCart(val){
            this.$store.commit("addToCart", val)
        }
    }
}
</script>

<style>
.product{
    flex: 1;
    margin: 10px;
    border: 2px solid black;
}

</style>