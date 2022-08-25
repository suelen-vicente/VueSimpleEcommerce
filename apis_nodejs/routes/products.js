const express = require('express');
const router = express.Router();
const {check, validationResult} = require('express-validator')

const Product = require('../models/products');

//Get all the products
router.get("/", async (req, res)=>{
    try{
        let filter = {}

        if(req.query.name){
            filter.name = req.query.name;
        }

        let products = await Product.find(filter);
        return res.status(200).json(products);
    }catch(error){
        res.status(400).json({error: error});
    }    
})

//Get product by id
router.get("/:id", async (req, res) => {
    try{
        let product = await Product.findOne({_id: req.params.id});

        if(!product){
            return res.status(200).json({message: "Product not found."})
        }

        return res.status(200).json(product)
    }catch(error){
        return res.status(400).json(error)
    }
})

//Create new product
router.put("/", [
        check("name").notEmpty().withMessage("Name is required"), 
        check("brand").notEmpty().withMessage("Brand is required").custom(val => validateEmail(val)),
        check("description").notEmpty().withMessage("Description is required"),
        check("image").notEmpty().withMessage("Image is required"),
        check("price").notEmpty().withMessage("Price is required"),
        check("shippingCost").notEmpty().withMessage("Shipping Cost is required")
    ], (req, res)=>{

    try{
        let product = new Product ({
            name: req.body.name,
            brand: req.body.brand,
            description: req.body.description,
            image: req.body.image,
            price: req.body.price,
            shippingCost: req.body.shippingCost
        });
        
        product.save().then(result => {
            return res.status(201).json(result)
        }).catch(err => {
            return res.status(400).json(err)
        })

    }catch(err){
        res.status(400).json(err);
    }
})

//Update product
router.post("/edit", async(req, res)=>{
    try{
        let prod = await Product.findOne({_id: req.body.id})
        
        if(!prod){
            res.status(404).json({error: "Product not found."});
            return
        }

        if(req.body.name){
            prod.name = req.body.name;
        }

        if(req.body.brand){
            prod.brand = req.body.brand;
        }

        if(req.body.description){
            prod.description = req.body.description;
        }

        if(req.body.image){
            prod.image = req.body.image;
        }

        if(req.body.price){
            prod.price = req.body.price;
        }

        if(req.body.shippingCost){
            prod.shippingCost = req.body.shippingCost;
        }

        prod.save().then(result => {
            return res.status(200).json(prod)
        }).catch(err => {
            return res.status(400).json(err)
        });

    }catch(err){
        res.status(400).json({error: err});
    }
})

//Delete Product by id
router.delete("/:id", async (req,res) =>{
    try{
        let result = await Product.deleteOne({_id: req.params.id})
        return res.status(200).json("Product deleted.")
    }catch(err){
        return res.status(400).json({error: err})
    }
})

module.exports = router;