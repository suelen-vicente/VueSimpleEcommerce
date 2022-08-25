import axios from "axios"


//Get cart by user
export const getUserCart = function(userId){
    return axios.get('http://localhost:5500/api/cart/user/' + userId)
}

//Add product to cart
export const addProduct = function(productInfo){
    console.log(productInfo);
    return axios.put('http://localhost:5500/api/cart/add-product',{productInfo})
}

//Change product quantity
export const changeProductQuantity = function(productInfo){
    console.log(productInfo);
    return axios.post('http://localhost:5500/api/cart',{productInfo})
}

//Remove product
export const removeProduct = function(productInfo){
    console.log(productInfo);
    return axios.post('http://localhost:5500/api/cart/delete-product',{productInfo})
}

//Clear cart
export const clear = function(userId){
    console.log(userId);
    return axios.delete('http://localhost:5500/api/cart/user/' + userId)
}