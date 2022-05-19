<template>
  <div>
      <form @submit.prevent="submit">
          <label>Email</label>
          <!-- v-model do a bind with the variable mentioned in the property -->
          <!-- This biding is real time, so, as the fiedls as being filled, the variables are also being filled. -->
          <input type="text" v-model="email">
          <br>

          <label>Password</label>
          <input type="password" v-model="password">
          <!-- This block will only appear if passwordError is true -->
          <p v-if="passwordError" style="color:red">*Password should be at least 5 characters</p>
          <br>
          
          <label>Country</label>
          <!-- This v-model will bind the selected country to this country property -->
          <select v-model="country">
              <!-- This automatically show all options inside of countryOptions array -->
              <!-- If someday a new country is added, you don't need to add a new option tag -->
              <option v-for="option in countryOptions" :value="option" :key="option">{{option}}</option>
          </select>
          <br>

          <div class="check">
              <label>Skills</label>
              <br>
              <label>Vue</label>
              <input type="checkbox" value="vue" v-model="skills">

              <label>.NET</label>
              <input type="checkbox" value="dotnet" v-model="skills">

              <label>PHP</label>
              <input type="checkbox" value="php" v-model="skills">
          </div>
          <p v-if="expertProgrammer" style="color:lightgreen">You are an expert programmer</p>

          <label>Gender</label>
          <br>
          <label>Male</label>
          <input type="radio" value="male" v-model="gender">

          <label>Female</label>
          <input type="radio" value="female" v-model="gender">

          <label>Other</label>
          <input type="radio" value="other" v-model="gender">
          <br>

          <input type="submit">
        
      </form>
  </div>
  <!-- <p>{{email}}</p>
  <p>{{password}}</p>
  <p>{{country}}</p>
  <p>{{skills}}</p>
  <p>{{gender}}</p> -->
</template>

<script>
export default {
  data(){
      return{
          email: "",
          password: "",
          countryOptions: ['India', 'Srilanka', 'Brazil', 'South Korea'],
          country: "",
          skills: [],
          gender: "",
          passwordError: true,
          expertProgrammer: false,
      }
  },

  methods: {
      submit(){
          console.log("Form is submitted.")
      }
  },

  watch:{
    //   This will monitor what password property have inside, its value
    // So, while typing, if password is more than 5, the warning don't show anymore at the screen
    password(){
        if(this.password.length > 5){
            this.passwordError = false
            return
        }
        this.passwordError = true
    },
    
    // If all the checkboxes for skill is marked, the Expert Programmer message is displayed
    skills(){
        if(this.skills.length > 2){
            this.expertProgrammer = true
            return
        }
        this.expertProgrammer = false
    },
  },
}
</script>

<style>
form {
  border: 2px solid black;
  max-width: 420px;
  margin: 30px auto;
  background: #101010;
  text-align: left;
  padding: 40px;
  border-radius: 10px;
}label {
  color: white;
  display: inline-block;
  margin: 25px 0 15px;
  font-size: 0.6em;
  text-transform: uppercase;
  letter-spacing: 1px;
  font-weight: bold;
}
input,
select {
  display: block;
  padding: 10px 6px;
  box-sizing: border-box;
  border: none;
  border-bottom: 1px solid #ddd;
  color: #555;
}
 input[type="checkbox"] {
  display: inline-block;
  width: 16px;
  margin: 5px 5px 0 0;
  position: relative;
  top: 2px;
}
 input[type="radio"] {
  display: inline-block;
  width: 16px;
  margin: 5px 5px 0 0;
  position: relative;
  top: 2px;
}
 button {
  background: white;
  border: 0;
  padding: 10px 20px;
  margin-top: 20px;
  color: black;
  border-radius: 20px;
}
 .submit {
  text-align: center;
}
 .error {
  color: #ff0062;
}

</style>