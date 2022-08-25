import axios from "axios" 

export const postSignUp = function(user){
    console.log(user);
    return axios.post("http://localhost:5500/api/users/signup", user);
}

export const postLogIn = function(loginData){
    console.log(loginData);
    return axios.post("http://localhost:5500/api/users/login", loginData);
}

export const postEditUser = function(editUser){
    console.log(editUser);
    return axios.post("http://localhost:5500/api/users/edit",editUser);
}

//delete user by Id
export const deleteUserById = function(id){
    console.log(id);
    return axios.delete('http://localhost:5500/api/users/' + id)
}


//get user by Id
export const getUserById = function(id){
    console.log(id);
    return axios.get('http://localhost:5500/api/users/' + id)
}

//get user by email
export const getUserByEmail = function(emailParam){
    return axios.get('http://localhost:5500/api/users/', { params: { email: emailParam }})
}

export const anonymous = function(){
    return axios.post("http://localhost:5500/api/users/anonymous");
}

