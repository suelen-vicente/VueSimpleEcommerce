<template>
  <div class="cart">
    <h1>This is Shopping Cart Page</h1>
    <div id="container">
      <div id="orders">
        <div id="items">
          <div id="detailOrder" class="cart" v-for="i in cart.items" :key="i.productId">
            <ul>
              <li>
                <div>
                  <span>
                    <img
                      :src="require('../assets/products/' + i.productImage)"
                      v-bind:alt="i.productName"
                    />
                  </span>
                  <h2>{{ i.productName }}</h2>
                  <h3>{{ i.productImage }}</h3>
                  <p>${{ i.productPrice }}</p>
                  <select v-model="i.quantity" @change="onChange($event, i.productId)">
                    <option
                      v-for="option in qtyOptions"
                      :value="option"
                      :key="option"
                    >
                      {{ option }}
                    </option>
                  </select>
                </div>
                <button
                  class="submit-btn remove-btn"
                  :value="i.productId"
                  @click="onClick($event)"
                >
                  remove
                </button>
              </li>
            </ul>
          </div>
        </div>
        <div id="price">
          <ul>
            <li>
              <p>Order Summary</p>
            </li>
            <li>
              <span>Subtotal</span>
              <p v-if="cart.subTotal">
                ${{ parseFloat(cart.subTotal).toFixed(2) }}
              </p>
            </li>
            <li>
              <span>Shipping</span>
              <p v-if="cart.subTotal">
                ${{ parseFloat(cart.shippingCost).toFixed(2) }}
              </p>
            </li>
            <li>
              <span>Tax</span>
              <p v-if="cart.subTotal">
                ${{ parseFloat(cart.taxes).toFixed(2) }}
              </p>
            </li>
            <li>
              <span>Total</span>
              <p v-if="cart.subTotal">
                ${{ parseFloat(cart.total).toFixed(2) }}
              </p>
            </li>
          </ul>
          <button class="submit-btn" @click="onClickProceedToCheckout($event)">Proceed to Checkout</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {getUserCart, changeProductQuantity, removeProduct, clear} from "../../api/cart-store"
import {createOrder} from "../../api/order-store"

export default {
  name: 'ShoppingCart',
  data() {
    return {
      cart: [],
      qtyOptions: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
      subTotal: 0,
      shipping: 15.0,
      tax: 0,
      grandTotal: 0,
    };
  },

  components: {},

  methods: {
    initValues(){
      this.subTotal = 0;
      this.shipping = 15.0;
      this.tax = 0;
      this.grandTotal = 0;
    },
    onChange(event, productId) {
      
      let currentUser = this.$store.getters.getCurrentUser._id;
      console.log(currentUser._id);

      let productInfo = {
        userId: currentUser,
        productId: productId,
        quantity: event.target.value
      }

      changeProductQuantity(productInfo).then(res => {
        if(res.status === 200){
          console.log("Product quantity modified successfuly.");

          getUserCart(currentUser).then(res=> {
            if(res.status == 200){
              this.cart = res.data[0];
            }else{
              if(res.status = 404){
                this.cart = [];
              }
            }
          }).catch((err) => {
            console.log(err);
          });

        }
      }).catch((err) => {
        console.log(err);
        alert("Error modifying quantity.")
      });

    },
    onClick(event) {
      let currentUser = this.$store.getters.getCurrentUser._id;

      let productInfo = {
        userId: currentUser,
        productId: event.target.value
      }

      removeProduct(productInfo).then(res => {
        if(res.status === 200){
          console.log("Product removed successfuly.")

          getUserCart(currentUser).then(res=> {
            if(res.status == 200){
              this.cart = res.data[0];
            }else{
              if(res.status = 404){
                this.cart = [];
              }
            }
          }).catch((err) => {
            console.log(err);
          });

        }
      }).catch((err) => {
        console.log(err);
        alert("Error removing quantity.")
      });
    },
    onClickProceedToCheckout(event){
      let currentUsername = this.$store.getters.getCurrentUser.name;
      let currentUserId = this.$store.getters.getCurrentUser._id;
      let isLogIn = this.$store.getters.getIsLogin;

      if(isLogIn){
        createOrder(currentUserId).then(res => {
          if(res.status === 201){
            alert(currentUsername + " proceeded to checkout. Order " + res.data._id + " created!");
            clear(currentUserId).then(res => {
              if(res.status == 200){
                this.cart = [];
              }
            })
          }
        }).catch((err) => {
          console.log(err);
          alert("Error creating order.")
        });
      }else{
        this.$router.push({name:'CustomerInfo'});
      }
    }
  }, 

  mounted() {
    let currentUser = this.$store.getters.getCurrentUser._id;
    this.cart = [];

    getUserCart(currentUser).then(res=> {
        if(res.status == 200){
          this.cart = res.data[0];
        }else{
          if(res.status = 404){
            this.cart = [];
          }
        }
    }).catch((err) => {
      console.log(err);
    });
  },
  updated() {},
};
</script>

<style>
/* From here for cart.html */
.cart {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

#container {
  margin: 0 auto;
  width: 100%;
}
#orders {
  width: 100%;
  height: 100%;
}

#items {
  float: left;
  width: 68%;
  height: 100%;
  background-color: #ebebeb;
}

#items ul {
  padding: 0;
  overflow: hidden;
  border: 2px solid whitesmoke;
}

#items ul li {
  width: 100%;
  text-align: left;
  margin: 5px 0;
  border-bottom: 2px solid #ebebeb;
}


#items ul li div {
  clear: both;
  width: 90%;
  height: 160px;
}

#items ul li span {
  float: left;
  display: block;
  margin: 10px 20px 10px 10px;
  width: 200px;
  height: 200px;
  border-radius: 2%;
  border: 2px solid whitesmoke;
  line-height: 150px;
}

#items ul li p {
  font-family: "Times New Roman", Times, serif;
  float: right;
  font-size: 20px;
  font-weight: 600;
}

#price {
  float: right;
  width: 30%;
  height: 100%;
  background-color: #ebebeb;
  border: 2px solid whitesmoke;
  border-radius: 2%;
}

#price ul {
  padding: 0;
  overflow: hidden;
}

#price ul li {
  width: 100%;
  height: 50px;
  text-align: left;
  margin: 10px 0;
  border-bottom: 2px solid whitesmoke;
}

#price ul li p {
  padding-left: 10px;
  text-align: right;
}

#price ul li h3,
#price ul li h2 {
  width: 80%;
  float: left;
  padding-left: 20px;
}

.shop {
  display: flex;
  flex-direction: row;
  height: 13%;
}

.submit-btn {
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

.remove-btn {
  float: right;
  margin-right: 50px;
}

</style>