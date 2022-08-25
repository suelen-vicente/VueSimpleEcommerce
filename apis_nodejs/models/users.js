const mongoose = require("mongoose");
const schema = mongoose.Schema;

// const shippingAddressSchema = new schema({
//     address: String,
//     city: String,
//     province: String,
//     postalCode: String
// })

const userSchema = new schema({
    name: {
        type: String,
        required: true
    },
    email: {
        type: String
    },
    password: {
        type: String
    },
    address: {
        type: String
    },
    phone: {
        type: String
    },
})

const User = mongoose.model("User", userSchema);

module.exports = User