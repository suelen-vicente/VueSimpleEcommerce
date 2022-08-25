const mongoose = require("mongoose");
const schema = mongoose.Schema;

const orderItemSchema = new schema({
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

const orderSchema = new schema({
    userId: mongoose.Schema.Types.ObjectId,
    status:{
        type: String,
        required: true
    },
    lastModified:{
        type : Date,
        required: true
    },
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
    items: [orderItemSchema]
});

const Order = mongoose.model("Order", orderSchema);
module.exports = Order;