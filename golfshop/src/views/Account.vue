<template>
    <!-- <p>Account ID is {{id}}</p> -->
    <div class="account-page">
        <div class="container">
            <div class="row">
                <div v-if="accountEditing" class="account">
                    <h1>Account editing </h1>
                    <h3>You can change personal information</h3>
                    <form class="form-group">
                        <input v-model="name" type="name" class="form-control" placeholder="Full name" required>
                        <input v-model="address" type="address" class="form-control" placeholder="Address" required>
                        <input v-model="phone" type="phone" class="form-control" placeholder="Phone" required>
                        <input v-model="emailReg" type="email" class="form-control" placeholder="Email" required>
                        <input v-model="passwordReg" type="password" class="form-control" placeholder="Password" required>
                        <p v-if="passwordError" style="color:red">*Password should be at least 5 characters</p>
                        <input v-model="confirmReg" type="password" class="form-control" placeholder="Confirm Password" required>
                        <p v-if="confirmPasswordError" style="color:red">*Password should be the same</p>
                        <input type="button" class="submit-btn" value="save" @click="doRegister">
                    </form>
                </div>
                <div v-else class="account-editting" >
                    <h3>Welcome {{this.$store.getters.getCurrentUser.email}}</h3>
                    <!-- <h3>Change account information?</h3> <a href="#" @click="doEditing">Accound editting</a> -->
                    <h3>Change account information?</h3>
                    <input type="button" class="submit-btn" value="Accound editting" @click="doEditing">
                </div>
            </div>
        </div>
    </div>
</template>

<script>

//import Restful API
import {deleteUserById,postEditUser,getUserById} from 'api/user-store'

export default {
    props: ["id"],
    data(){
        return{
            name: "",
            address: "",
            phone: "",
            emailReg: "",
            passwordReg: "",
            confirmReg: "",
            emptyFields: false,
            passwordError: false,
            confirmPasswordError: false,
            accountEditing: false,
        }
    },

    methods: {
    doRegister() {
        if (this.confirmPasswordError == true || this.emailReg === "" || this.passwordReg === "" || this.confirmReg === "") {
            this.emptyFields = true;
        } else {
            // remove old user
            //this.$store.commit("removeFromUser", this.$store.getters.getCurrentUser);
            // deleteUserById(this.$route.params.id).then(res=> {
            //     console.log(res);
            // })
            // .catch((err) => {
            //     console.log(err);
            // });
            // update new user
            const newUser = {
              id: this.$route.params.id,
              name:this.name,
              address:this.address,
              phone:this.phone,
              email:this.emailReg,
              password:this.confirmReg,
            };
            console.log(newUser);
            //this.$store.commit("addtoUser", newUser)
            postEditUser(newUser).then(res=>{
                // Update current user
                // this.$store.commit("setCurrentUser", this.$store.getters.getUserByEmail(this.emailReg));
                this.$store.commit("setCurrentUser", res.data);
                this.$store.commit("setIsLogIn", true);

                // Update the field
                this.accountEditing = false;

                // Update view
                this.$router.push({name:'Account', params:{id: res.data._id}});
                alert("Your information is saved.");
            })
             .catch((err) => {
              console.log(err);
            });
        }
    },

    doEditing() {
        console.log(this.$route.params.id);
        
        getUserById(this.$route.params.id).then(res=> {
            console.log(res);
            this.accountEditing = !this.accountEditing;
            const user = res.data;
            this.name = user.name,
            this.address = user.address,
            this.phone = user.phone,
            this.emailReg = user.email
            
        })
        .catch((err) => {
            console.log(err);
        });


        // this.name = this.$store.getters.getCurrentUser.name,
        // this.address = this.$store.getters.getCurrentUser.address,
        // this.phone = this.$store.getters.getCurrentUser.phone,
        // this.emailReg = this.$store.getters.getCurrentUser.email
     },
},

    watch:{
        //   This will monitor what password property have inside, its value
        // So, while typing, if password is more than 5, the warning don't show anymore at the screen
        passwordReg(){
            if(this.passwordReg == "" || this.passwordReg.length > 5){
                this.passwordError = false;
                return
            }
            this.passwordError = true;
        },

        confirmReg(){
            if(this.confirmReg == "" || this.passwordReg == this.confirmReg){
                this.confirmPasswordError = false;
                return
            }
            this.confirmPasswordError = true;
        },
    },
}
</script>

<style scoped>
.p {
	font-size: 14px;
	font-weight: 100;
	line-height: 20px;
	letter-spacing: 0.5px;
	margin: 20px 0 30px;
  font-family: 'Montserrat', sans-serif;
}

.form-group {
   padding: 20px;
}

.form-group input{
  margin-bottom: 20px;
  background-color: #eee;
	border: none;
	padding: 12px 15px;
	margin: 8px 0;
	width: 90%;
}

.account-page {
   align-items: center;
   display: flex;
   justify-content: center;
   height: 100vh;
   /* width: 50vh; */
}

.account-page h1 {
      margin-bottom: 1.5rem;
}

.error {
   animation-name: errorShake;
   animation-duration: 0.3s;
}

.form-group .submit-btn {
  margin-left:10px;
	border-radius: 20px;
	border: 1px solid black;
	background-color: green;
	color: #FFFFFF;
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
	border-color: #FFFFFF;
}

.account-editting {
	margin: 80px 0 30px;
}

</style>