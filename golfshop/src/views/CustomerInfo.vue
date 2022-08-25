<template>
  <div class="customer-info-page">
    <div class="container">
      <div class="row">
        <div class="card register" v-bind:class="{ error: emptyFields }">
          <h1>Customer Info</h1>
          <form class="form-group" @submit.prevent="doCheckOut">
            <input
              v-model="name"
              type="name"
              class="form-control"
              placeholder="Full name"
              required
            />
            <input
              v-model="address"
              type="address"
              class="form-control"
              placeholder="Address"
              required
            />
            <input
              v-model="phone"
              type="phone"
              class="form-control"
              placeholder="Phone"
              required
            />
            <p v-if="v$.phone.$error" style="color: red">{{ v$.phone.$errors[0].$message }}</p>
            <input
              v-model="emailReg"
              type="email"
              class="form-control"
              placeholder="Email"
              required
            />
            <p v-if="v$.emailReg.$error" style="color: red">{{ v$.emailReg.$errors[0].$message }}</p>
            <input
              type="submit"
              class="submit-btn"
              value="Check Out"
              
            />
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {clear} from "../../api/cart-store"
import {createOrder} from "../../api/order-store"
import {postEditUser} from "../../api/user-store"

//import input validator
import useValidate from "@vuelidate/core";
import { required, email, minLength, helpers } from "@vuelidate/validators";

//valid phone number
const validPhoneNum = (val) => {
  console.log(val)
  var re = /^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]\d{3}[\s.-]\d{4}$/;
  return re.test(val);
};

//valid email
const validEmail = (val) => {
  var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(val);
};

export default {

  data() {
    return {
      v$: useValidate(),
      name: "",
      address: "",
      phone: "",
      emailReg: "",
      registerActive: false,
      emptyFields: false,
    };
  },

  validations() {
    return {
      phone:{
        required,
        validPhoneNum: helpers.withMessage("Wrong Phone Number Format. It must be in the format: 555-555-5555", validPhoneNum),
      },
      emailReg: {
        required,
        email,
        validEmail: helpers.withMessage("Wrong eMail Format", validEmail),
      },
    };
  },

  methods: {
    
    doCheckOut(){
      this.v$.$touch();
      if(this.v$.$invalid){
        alert("Check your Info.")
      }else{
          
      let currentUserId = this.$store.getters.getCurrentUser._id;
      let newUser = {
        id: currentUserId,
        name: this.name,
        address: this.address,
        phone: this.phone,
        email: this.emailReg
      }

      postEditUser(newUser).then(res => {
        let username = res.data.name;

        if(res.status == 200){
          createOrder(currentUserId).then(res => {
            if(res.status === 201){
              alert(username + " proceeded to checkout. Order " + res.data._id + " created!");
              
              clear(currentUserId).then(res => {
                if(res.status == 200){
                  this.cart = [];
                }
              })
              
            }
          });
        }
      }).catch((err) => {
        console.log(err);
        alert("Error creating order.")
      });

    }
    }
  },
};
</script>

<style>
.p {
  font-size: 14px;
  font-weight: 100;
  line-height: 20px;
  letter-spacing: 0.5px;
  margin: 20px 0 30px;
  font-family: "Montserrat", sans-serif;
}

.card {
  padding: 20px;
}

.form-group input {
  margin-bottom: 20px;
  background-color: #eee;
  border: none;
  padding: 12px 15px;
  margin: 8px 0;
  width: 90%;
}

.customer-info-page {
  align-items: center;
  display: flex;
  justify-content: center;
  height: 100vh;
  /* width: 50vh; */
}

.login-page h1 {
  margin-bottom: 1.5rem;
}

.error {
  animation-name: errorShake;
  animation-duration: 0.3s;
}

.form-group .submit-btn {
  margin-left: 10px;
  border-radius: 20px;
  border: 1px solid black;
  background-color: green;
  color: #ffffff;
  font-size: 12px;
  font-weight: bold;
  padding: 12px 45px;
  letter-spacing: 1px;
  text-transform: uppercase;
  transition: transform 80ms ease-in;
}

.submit-btn:active {
  transform: scale(0.95);
}

.submit-btn:focus {
  outline: none;
}

.submit-btn.ghost {
  background-color: transparent;
  border-color: #ffffff;
}

/* body {
	background: #f6f5f7;
	display: flex;
	justify-content: center;
	align-items: center;
	flex-direction: column;
	font-family: 'Montserrat', sans-serif;
	margin: -20px 0 50px;
} */

.container {
  background-color: #fff;
  border-radius: 10px;
  box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
  position: relative;
  overflow: hidden;
  width: 368px;
  max-width: 100%;
  min-height: 480px;
}
</style>