import axios from "axios"


//get all product
export const getProducts = function(){
    return axios.get("http://localhost:5500/api/products")
}

//get product by Id
export const getProductById = function(id){
    console.log(id);
    return axios.get('http://localhost:5500/api/products/' + id)
}

