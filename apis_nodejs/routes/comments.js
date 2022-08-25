const express = require('express');
const router = express.Router();
const { check, validationResult } = require('express-validator')

const Comment = require('../models/comments');

// GET COMMENTS WITH FILTER
router.get("/:productId", async (req, res) => {
    try {

        console.log(req.params.productId);
        let comments = await Comment.find({productId:req.params.productId});

        if (!comments || comments.length === 0) {
            return res.status(404).json("Comments not found.");
        }

        return res.status(200).json(comments);
    } catch (error) {
        res.status(400).json({ error: error });
    }
})

// CREATE
router.put("/", (req, res) => {
    
    request = req.body.commentInfo;

    const comment = new Comment({
        productId: request.productId,
        username: request.username,
        text: request.text
    });
    //In this case, we are using the promise, so we don't need the async command in the beggining
    comment.save().then(result => {
        return res.status(201).json(result);
    }).catch(err => {
        return res.status(400).json({error: err})
    })
});


// UPDATE
router.post("/edit",async(req,res)=>{
    try{
        let comm = await Comment.findOne({_id:req.body.id})

        if(!comm){
            res.status(404).json({error:"Comment not found."});
            return
        }

        if(req.body.rating){
            comm.rating = req.body.rating;
        }

        if(req.body.image){
            comm.image = req.body.image;
        }

        if(req.body.text){
            comm.text = req.body.text;
        }

        comm.save().then(result => {
            return res.status(200).json(comm)
        }).catch(err => {
            return res.status(400).json(err)
        });
    }catch(err){
        res.status(400).json({error:err});
    }
})

// DELETE
router.delete("/:id", async (req,res) => {
    try{
        let result = await Comment.deleteOne({_id: req.params.id})
        return res.status(200).json("Comment deleted.")
    }catch(err){
        return res.status(400).json({error:err})
    }
})

// DELETE BY USER
router.delete("/user/:id", async (req,res) => {
    try{
        let result = await Comment.deleteMany({userId: req.params.id})
        return res.status(200).json("Comments deleted.")
    }catch(err){
        return res.status(400).json({error:err})
    }
})

// DELETE BY PRODUCT
router.delete("/product/:id", async (req,res) => {
    try{
        let result = await Comment.deleteMany({productId: req.params.id})
        return res.status(200).json("Comments deleted.")
    }catch(err){
        return res.status(400).json({error:err})
    }
})
module.exports = router