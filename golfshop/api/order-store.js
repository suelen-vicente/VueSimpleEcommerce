import axios from "axios"

//Create order
export const createOrder = function(userId){
    return axios.put('http://localhost:5500/api/orders/' + userId)
}

//Create order
export const getOrdersByUser = function(userId){
    return axios.get('http://localhost:5500/api/orders/user/' + userId)
}