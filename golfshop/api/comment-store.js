import axios from "axios"

//Get Comments by product
export const getCommentsByProduct = function(product){
    return axios.get('http://localhost:5500/api/comments/' + product);
}

//Add comment
export const createComment = function(commentInfo){
    return axios.put('http://localhost:5500/api/comments/',{commentInfo});
}