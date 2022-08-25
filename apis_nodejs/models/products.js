const mongoose = require("mongoose");
const schema = mongoose.Schema

const productSchema = new schema({
    name: {
        type: String,
        required: true
    },
    brand: {
        type: String,
        required: true
    },
    description: {
        type: String,
        required: true
    },
    image: {
        type: String,
        required: true
    },
    price:{
        type: Number,
        required: true
    },
    shippingCost:{
        type: Number,
        required: true
    }
});

const Product = mongoose.model("Product", productSchema);
module.exports = Product;