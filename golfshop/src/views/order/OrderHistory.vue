<template>
  <h1>Your Orders</h1>
    <div class="grid">
        <div class="order" v-for="o in orders" :key="o._id">
            <!-- <router-link class="orderinfo" :to="{name: 'OrderDetails', params:{id: o._id}}"> <h4>{{o._id}}</h4> </router-link> -->
            <p class="orderinfo">{{o._id}}</p>
            <p class="orderinfo">{{o.status}}</p>
            <p class="orderinfo">${{o.lastModified}}</p>
        </div>
    </div>
  <br>
</template>

<script>
import {getOrdersByUser} from "../../../api/order-store"

export default {
    name: "Orders",
    data(){
        return{
            orders: []
        }
    },

    mounted(){
        let currentUserId = this.$store.getters.getCurrentUser._id;
        console.log("HERE")
        getOrdersByUser(currentUserId).then(res=> {
            console.log(res.data);
            this.orders = res.data;
        });
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

    .order{
        flex: 1;
        margin: 10px;
        border: 2px solid white;
        border-radius: 20px;
        background-color: white;
    }

    .orderinfo{
        color: black;
        margin: 0px;
    }

</style>