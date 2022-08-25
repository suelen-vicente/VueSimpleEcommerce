<template>
  <div class="login-page">
    <div class="container">
      <div class="row">
        <div
          v-if="!registerActive"
          class="card login"
          v-bind:class="{ error: emptyFields }"
        >
          <h1>Sign In</h1>
          <form class="form-group" @submit.prevent="doLogin">
            <input
              v-model="emailLogin"
              type="email"
              class="form-control"
              placeholder="Email"
              required
            />
            <input
              v-model="passwordLogin"
              type="password"
              class="form-control"
              placeholder="Password"
              required
            />
            <input
              type="submit"
              class="submit-btn"
              value="Submit"
            />
            <p>
              Don't have an account?
              <a
                href="#"
                @click="
                  (registerActive = !registerActive), (emptyFields = false)
                "
                >Sign up here</a
              >
            </p>
            <p><a href="#">Forgot your password?</a></p>
          </form>
        </div>

        <div v-else class="card register" v-bind:class="{ error: emptyFields }">
          <h1>Sign Up</h1>
           <form class="form-group" @submit.prevent="doRegister">
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
              v-model="passwordReg"
              type="password"
              class="form-control"
              placeholder="Password"
              required
            />
            <p v-if="passwordError" style="color: red">
              *Password should be at least 5 characters
            </p>
            <input
              v-model="confirmReg"
              type="password"
              class="form-control"
              placeholder="Confirm Password"
              required
            />
            <p v-if="confirmPasswordError" style="color: red">
              *Password should be the same
            </p>
            <input
              type="submit"
              class="submit-btn"
              value="Submit"
              
            />
            <p>
              Already have an account?
              <a
                href="#"
                @click="
                  (registerActive = !registerActive), (emptyFields = false)
                "
                >Sign in here</a
              >
            </p>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
//import input validator
import useValidate from "@vuelidate/core";
import { required, email, minLength, helpers } from "@vuelidate/validators";

//import Restful API
import { postSignUp, postLogIn, getUserByEmail } from "api/user-store";

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
      registerActive: false,
      emailLogin: "",
      passwordLogin: "",
      emailReg: "",
      passwordReg: "",
      confirmReg: "",
      emptyFields: false,
      passwordError: false,
      confirmPasswordError: false,
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
      passwordReg: { required, minLength: minLength(6) },
    };
  },

  methods: {
    
    doLogin() {
      if (this.emailLogin === "" || this.passwordLogin === "") {
        this.emptyFields = true;
        this.$store.commit("setIsLogIn", false);
      } else {
        const newLoginData = {
          email: this.emailLogin,
          password: this.passwordLogin,
        };

        postLogIn(newLoginData)
          .then((res) => {
            console.log(res.data.user._id);
            if (res.status === 200) {
              this.$store.commit("setCurrentUser", res.data.user);
              this.$store.commit("setIsLogIn", true);
              this.$router.push({
                name: "Account",
                params: { id: res.data.user._id },
              });
              alert("You are now logged in");
            } else {
              this.emailLogin = "";
              this.passwordLogin = "";
              alert("You're not a registered user.");
            }
          })
          .catch((err) => {
            console.log(err);
            this.emailLogin = "";
            this.passwordLogin = "";
            alert("You're not a registered user.");
          });

      }
    },

    doRegister() {
      this.v$.$touch();
      if (
        this.emailReg === "" ||
        this.passwordReg === "" ||
        this.confirmReg === ""
      ) {
        this.emptyFields = true;
      } else if(this.v$.$invalid){
          alert("Check your Info.")
      }else{
        console.log("emailTest" + this.emailReg);
        getUserByEmail(this.emailReg)
          .then(res =>{
            if (res.data[0]){
              console.log(res.data)
              alert("Email is already registered")
            }else{

              const newUser = {
                name: this.name,
                address: this.address,
                phone: this.phone,
                email: this.emailReg,
                password: this.confirmReg,
              };

              postSignUp(newUser)
                .then((res) => {
                  console.log(res.data);
                  this.registerActive = false;
                  this.$router.push({ name: "SignUp" });
                  alert("You are now registered", newUser);
                })
            }
          })
          .catch((err) => {
            console.log(err);
          });
      }
    },
  },

  watch: {
    //   This will monitor what password property have inside, its value
    // So, while typing, if password is more than 5, the warning don't show anymore at the screen
    passwordReg() {
      if (this.passwordReg == "" || this.passwordReg.length > 5) {
        this.passwordError = false;
        return;
      }
      this.passwordError = true;
    },

    confirmReg() {
      if (this.confirmReg == "" || this.passwordReg == this.confirmReg) {
        this.confirmPasswordError = false;
        return;
      }
      this.confirmPasswordError = true;
    },
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

.login-page {
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
