const mongoose = require("mongoose");
const schema = mongoose.Schema;

const commentSchema = new schema({
    // This is how we use foreign keys in the mongo db database
    // This means that this field will refer to the users table
    productId: mongoose.Schema.Types.ObjectId,
    username: String,
    text: {
        type: String,
        required: true
    }
});

const Comment = mongoose.model("Comment", commentSchema);
module.exports = Comment;