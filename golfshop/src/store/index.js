import { createStore } from "vuex";

export default createStore({
    state(){
        return{
            products: [
                {id: "62f2bf0971ebbbd5f2d930b4", image: "iron_club.jpeg", name: "P790 2021 4-PW Iron Set", price: 1699.99, brand: "Taylormade", qty: 1},
                {id: 2, image: "driver_club.jpeg", name: "SIM2 Max Driver", price: 699.99, brand: "Taylormade", qty: 1},
                {id: 3, image: "huntington_beach_soft_putter.jpeg", name: "Huntington Beach Soft Putter", price: 169.99 , brand: "Cleveland", qty: 1},
                {id: 4, image: "putter_club.jpeg", name: "Putter with Pistol Grip", price: 269.99 , brand: "Taylormade", qty: 1},
                {id: 5, image: "hoofer_14_standing_bag.jpeg", name: "Hoofer 14 Stand Bag", price: 339.99 , brand: "Ping", qty: 1},
            ],
            cart: [],
            reviews: [{id: 1, comments:[{user: "customer1",content:"Very good"},
                                         {user: "customer2",content:"Awsome"}
                                        ]},
                      {id: 2, comments:[{user: "customer3",content:"Very good"},
                                         {user: "customer4",content:"Awsome"}
                                        ]},
                      {id: 3, comments:[]},
                      {id: 4, comments:[]},
                      {id: 5, comments:[]},
                    ],
            users: [
                {name: "1", address: "1", phone: "1", email: "1@gmail.com", password: "111111"},
            ],
            selectedUser: []
            ,
            isLogIn: false,
        }
    },
    mutations: {
        setIsLogIn(state, logIn) {
            console.log("isLogin value:", logIn);
            state.isLogIn = logIn
        },
        setCurrentUser(state, userinfo) {
            console.log("setCurrentUser:", userinfo);
            state.selectedUser = userinfo
        },
        addtoUser(state, userinfo){
            state.users.push(userinfo)
        },
        removeFromUser(state, userinfo) {
            state.users.pop(userinfo)
        },
        addToCart(state, payload){
            state.cart.push(payload)
        },
        removeFromCart(state, payload){
            state.cart.pop(payload)
        },
        addQuantity(state, product, quantity){
            console.log(quantity);
            let productIndex = state.cart.findIndex(item => item.id == product.id);
            if(productIndex){
                state.cart[productIndex].qty = parseInt(state.cart[productIndex].qty) + parseInt(quantity);
            }
        },
        setSelectedProduct(state, product){
            state.selectedProduct = product
        },

        addToReviews(state, payload){
            state.reviews.push(payload)
        },
        addComments(state, payload){
            console.log(payload);
            const productIndex = state.reviews.findIndex(item => item.id ===payload.id);
            console.log(productIndex);
            state.reviews[productIndex].comments.push(payload.comments)
        },

    },
    
    getters: {
        getIsLogin(state) {
            return state.isLogIn
        },
        getUserByEmail: (state) => (email) => {
            console.log("getUserByEmail:", email);
            console.log("getUserByEmail:", state.users.find(user => user.email === String(email)));
            return state.users.find(user => user.email === String(email))
        },
        getUserByPassword: (state) => (password) => {
            console.log("getUserByPassword:", password);
            console.log("getUserByPassword:", state.users.find(user => user.password === String(password)));
            return state.users.find(user => user.password === String(password))
        },
        getUser(state) {
            return state.users
        },
        getCurrentUser(state) {
            console.log("getCurrentUser:", state.selectedUser);
            return state.selectedUser
        },
        getProducts(state){
            return state.products
        },

        getCart(state){
            return state.cart
        },
        getProductById: (state) => (id) => {
            return state.products.find(product => product.id === Number(id))
        },
        getCartProductById: (state) => (id) => {
            return state.cart.find(product => product.id === Number(id))
        },
        getQuantityByProductId: (state) => (id) =>{
            let productCart = state.cart.find(product => product.id === Number(id))
            if(productCart){
                return productCart.qty
            }else{
                return 1
            }
        },
        getReviewsById: (state) => (id) => {
            let review = state.reviews.find(review => review.id === Number(id))
            if(review){
                return review
            }else{
                return 
            }
        },
    }
})