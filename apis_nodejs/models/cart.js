const mongoose = require("mongoose");
const schema = mongoose.Schema;

const cartItemSchema = new schema({
    productId: mongoose.Schema.Types.ObjectId,
    productName: {
        type: String,
        required: true
    },
    productImage: {
        type: String,
        required: true
    },
    productPrice: {
        type: Number,
        required: true
    },
    productShippingCost: {
        type: Number,
        required: true
    },
    quantity:{
        type: Number,
        required: true
    }
})

const cartSchema = new schema({
    userId: mongoose.Schema.Types.ObjectId,
    subTotal:{
        type: Number,
        required: true
    },
    shippingCost:{
        type: Number,
        required: true
    },
    taxes:{
        type: Number,
        required: true
    },
    total:{
        type: Number,
        required: true
    },
    items: [cartItemSchema]
});

const Cart = mongoose.model("Cart", cartSchema);
module.exports = Cart;