<template>
    <button class="shopbutton" @click="addToCart(product, quantity)">Add to cart</button>
</template>

<script>
import {addProduct} from "../../api/cart-store";
import {anonymous} from '../../api/user-store';

export default {
    props: ['product', 'quantity'],

    methods: {
        addToCart(product, quantity){

            let currentUserId = this.$store.getters.getCurrentUser._id;
            let currentUsername = this.$store.getters.getCurrentUser.name;

            if(!currentUserId){

                anonymous().then(res => {
                    if(res.status === 201){
                        this.$store.commit("setCurrentUser", res.data);
                        this.$store.commit("setIsLogIn", false);

                        currentUserId = this.$store.getters.getCurrentUser._id;
                        currentUsername = this.$store.getters.getCurrentUser.name

                        let productInfo = {
                            userId: currentUserId,
                            productId: product._id,
                            quantity: quantity
                        }

                        addProduct(productInfo).then(res => {
                        if(res.status === 201){
                            alert("Product " + product.name + "\n Quantity: " 
                                + quantity + "\n added to " + currentUsername +"'s cart")
                        }
                        }).catch((err) => {
                        console.log(err);
                        alert("Error adding product to cart.")
                        });
                    }
                }).catch((err) => {
                    console.log(err);
                    alert("Error adding product to cart.")
                });
            }else{
    
                let productInfo = {
                    userId: currentUserId,
                    productId: product._id,
                    quantity: quantity
                }
    
                addProduct(productInfo).then(res => {
                  if(res.status === 201){
                    alert("Product " + product.name + "\n Quantity: " 
                           + quantity + "\n added to " + currentUsername +"'s cart")
                  }
                }).catch((err) => {
                  console.log(err);
                  alert("Error adding product to cart.")
                });
            }

        },
    }

}
</script>

<style>
    .shopbutton{
        background-color: #058C42;
        color: white;
        width: 100%;
        margin-right: 10px;
        border-radius: 10px;
        margin-bottom: 0px;
        border: none;
    }
</style>