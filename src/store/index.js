import { createStore } from "vuex";


// This will store all the global components and info of the app
export default createStore({
    // This is like the data
    state(){
        return{
            products: [
                {id: 1, name: "Dark Roast", price: 2.50, size: "M"},
                {id: 2, name: "Espresso", price: 1.50, size: "S"},
                {id: 3, name: "Normal Blend", price: 3.50, size: "L"},
            ],
            cart: [],
        }
    },
    // This is like the methods
    // This means that we are trying to change a data inside of store
    mutations: {
        addToCart(state, payload){
            state.cart.push(payload)
        },
    },
    // This is only for get the store properties
    // mutation: setters, getters: getters :) 
    getters: {
        getProducts(state){
            return state.products
        },

        getCart(state){
            return state.cart
        },
    }
})