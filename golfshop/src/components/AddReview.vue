<template>
    <button class="submit-btn" @click="addToReview(product, username, content)">Add</button>
</template>

<script>

import {createComment} from "../../api/comment-store"

export default {
    name: "AddReview",
    props: ['product', 'username', 'content'],

    methods: {
        addToReview(product, username, content){

            let commentInfo = {
                username, username,
                productId: product._id,
                text: content
            }

            createComment(commentInfo).then(res => {
                //refresh list
            }).catch((err) => {
                console.log(err);
                alert("Error creating comment.")
            });
        },
    }

}
</script>

<style>
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
</style>