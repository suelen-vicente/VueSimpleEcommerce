<template>
  <div >
    <h2>Product Details</h2>
    <div v-if="product != ''">
    <div class="background">
      <div class="product-image" >
        <img :src="require('../../assets/products/'+ product.image)" v-bind:alt="product.name"/>
      </div> 
      <div class="product-details">
        <h2 class="product-details-text">{{ product.name }}</h2>
        <p class="product-details-text">{{ product.brand }}</p>
        <p class="product-details-text">
          {{product.description}}
        </p>
        <div class="price-shop-product">
          <p class="product-details-price">${{ product.price }}</p>
          <div class="shop-product">
            <QuantityCounter :product="product" @clicked="onClickChild" />
            <Shop :product="product" :quantity="qtd" />
          </div>
        </div>
      </div>
    </div>
    <br />
    <div class="addreview">
      <div class="inputreview">
        <input
          class="name"
          type="text"
          v-model="username"
          placeholder="Name"
          required
        />
        <input
          class="review"
          type="text"
          v-model="content"
          placeholder="Review"
          required
        />
        <AddReview :product="product" :username="username" :content="content" />
      </div>
    </div>
    <br />
    <div class="reviews">
      <div class="review-details" v-for="c in comments" :key="c.username">
        <p>{{ c.username }}</p>
        <p>"{{ c.text }}"</p>
      </div>
    </div>
    </div>
    <div v-else>
        Loading...
    </div>
  </div>
</template>

<script>
import Shop from "@/components/Shop";
import QuantityCounter from "@/components/QuantityCounter";
import AddReview from "../../components/AddReview.vue";
import {getProductById} from "api/product-store"
import {getCommentsByProduct} from "api/comment-store"


export default {
  name: "ProductDetails",
  props: ['id'],
  components: {
    Shop,
    QuantityCounter,
    AddReview,
  },
  data() {
    return {
      product: "",
      comments: [],
      qtd: 1,
      username: this.$store.getters.getCurrentUser.name,
      content: "",
    };
  },
  
  methods: {
    onClickChild(quantity) {
      this.qtd = quantity;
    },
  },

 
  // Html has rendered, css and javascript computed properly, so can access
  // everyone of them
  mounted(){
      getProductById(this.$route.params.id).then(res=>{
        this.product = res.data;
      })
      .catch((err) => {
        console.log(err);
      });

      getCommentsByProduct(this.$route.params.id).then(res=>{
        this.comments = res.data;
        console.log(this.comments);
      }).catch((err) => {
        console.log(err);
      });

  },

};
</script>

<style>
.name {
  width: 15%;
}
.review {
  width: 85%;
}
.addreview {
  display: flex;
  justify-content: center;
}
.inputreview {
  display: flex;
  width: 90%;
}
.background,
.reviews {
  background-color: #ebebeb;
  border-radius: 20px;
  border: white 1px;
  width: 100%;
  display: flex;
}

.product-image {
  border-radius: 20px;
  width: 30%;
  margin: 1%;
  display: block;
  float: left;
}

img {
  border-radius: 20px;
  width: 100%;
}

.product-details,
.review-details {
  float: right;
  background-color: white;
  border-radius: 20px;
  margin: 1%;
  width: 66%;
  justify-content: left;
  position: relative;
}

.shop-product {
  display: flex;
  flex-direction: row;
  height: 100%;
}

.product-details-text {
  display: flex;
  margin: 3%;
  width: 50%;
  text-align: left;
  flex-direction: row;
}

.product-details-price {
  margin: 10px 15px;
  text-align: right;
  font-size: larger;
}

.price-shop-product {
  position: absolute;
  bottom: 0;
  right: 0;
  margin-bottom: 2%;
  width: 50%;
  float: right;
}
</style>