<template>
  <h1>Our Products</h1>
    <div class="grid">
        <div class="product" v-for="p in products" :key="p.id">
            <div class="image">
                <img :src="require('../../assets/products/' + p.image)" v-bind:alt="p.name"/>
            </div>
            <router-link class="productinfo" :to="{name: 'ProductDetails', params:{id: p._id}}"> <h4>{{p.name}}</h4> </router-link>
            <p class="productinfo">{{p.brand}}</p>
            <p class="productinfo">${{p.price}}</p>
            <div class="shop">
                <QuantityCounter :product="p" @clicked="onClickChild"/>
                <Shop :product="p" :quantity="qtd"/>
            </div>
        </div>
    </div>
  <br>
</template>

<script>
import Shop from '@/components/Shop'
import QuantityCounter from '@/components/QuantityCounter'
// import {getProducts} from "api/product-store.js"
import {getProducts,getProductById} from "../../../api/product-store"

export default {
    name: "Products",
    components:{
        Shop,
        QuantityCounter,
    },

    data(){
        return{
            products: [],
            qtd: 1
        }
    },

    methods:{
        onClickChild (quantity) {
            this.qtd = quantity
        }
    },

    mounted(){
        // this.products = this.$store.getters.getProducts
        getProducts().then(res=> {
            console.log(res.data);
            this.products = res.data;
        })
    },
}

</script>

<style>
    .grid{
        background-color: #EBEBEB;
        border-radius: 20px;
        border: white 1px;
        width: 100%;
        display: grid;
        gap: 10px;
        grid-template: repeat(2, 1fr) / repeat(4, 1fr);
        grid-auto-flow: row;
    }

    .product{
        flex: 1;
        margin: 10px;
        border: 2px solid white;
        border-radius: 20px;
        background-color: white;
        height: 430px;
    }

    .image{
        width: 200px;
        height: 200px;
        margin: 10px;
        margin-left: auto;
        margin-right: auto;
        display: block;
        justify-content: center;
    }

    .productinfo{
        color: black;
        margin: 0px;
    }

    .shop{
        display: flex;
        flex-direction: row;
        height: 13%;
    }

</style>