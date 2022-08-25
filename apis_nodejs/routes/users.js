
const express = require('express');
const jwt = require('jsonwebtoken');
const bcrypt = require('bcrypt');
const {check, validationResult} = require('express-validator')

const {secret} = require('../config');
const User = require('../models/users');

const router = express.Router();

const userIsAuthorized = (req, res, next) => {
    const token = req.cookies.token;
    if(!token){
        res.redirect("/");
        return;
    }

    const user = jwt.verify(token, secret);
    if(!user){
        res.clearCookie("token");
        res.redirect("/");
        return;
    }

    req.user = user;
    next();
}

let validateEmail = (email) => {
    if (!String(email)
    .toLowerCase()
    .match(
      /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    )) {
        throw new Error("Check the email validation");
    }

    return true
}

// Get all users
router.get("/", async (req,res) =>{
    console.log(req);
    let filter = {}

    if(req.query.name){
        filter.name = req.query.name;
    }

    if(req.query.email){
        filter.email = req.query.email;
    }

    try{
        const users =  await User.find(filter)
        return res.status(200).json(users)
    }catch(err){
        return res.status(400).json({error: err})
    }
})

//Get a user by id
router.get("/:id", async (req,res) =>{
    try{
        const user =  await User.findById(req.params.id)
        
        if(!user){
            return res.status(404).json("User not found.")
        }

        return res.status(200).json(user)
    }catch(err){
        return res.status(400).json({error: err})
    }
})

//Delete a user by id
router.delete("/:id", async (req,res) =>{
    try{
        let result = await User.deleteOne({_id: req.params.id})
        return res.status(200).json("User deleted.")
    }catch(err){
        return res.status(400).json({error: err})
    }
})

router.post("/login", [
    check("email").notEmpty().withMessage("Email is required"), 
    check("password").notEmpty().withMessage("Password is required") 
], async(req, res) => {
    try{
        const errors = validationResult(req)
    
        if(!errors.isEmpty()){
            return res.status(400).json({errors: errors.array()})
        }
    
        let user = await User.findOne({email: req.body.email})
    
        if(!user){
            res.status(404).json({error: "Email or password informed are incorrect."});
            return
        }
    
        let passwordMatched = await bcrypt.compare(req.body.password, user.password);
    
        if(!passwordMatched){
            return res.status(404).json({error: "Email or password informed are incorrect."})
        }
    
        let userObj = {
            email: user.email,
            password: user.password
        }

        const token = jwt.sign(userObj, secret, {expiresIn: '2h'});
    
        res.cookie('token', token, {
            httpOnly: true,
            maxAge: 100000
        });
    
        res.status(200).json({message: "Logged In", user});

    }catch(err){
        res.status(400).json({error: err});
    }
});

//Create a new user
router.post("/signup", [
        check("name").notEmpty().withMessage("Name is required"), 
        check("email").notEmpty().withMessage("Email is required").custom(val => validateEmail(val)),
        check("password").notEmpty().withMessage("Password is required") 
    ], async (req, res) => {
    try{
        const errors = validationResult(req)

        if(!errors.isEmpty()){
            return res.status(400).json({errors: errors.array()})
        }

        let isUser = await User.findOne({email: req.body.email})

        if (isUser) {
            return res.status(400).json({error: "Email is already exist."})
        }

        const salt = await bcrypt.genSalt(10); 
        const password = await bcrypt.hash(req.body.password, salt)
    
        let user = new User ({
            name: req.body.name,
            email: req.body.email,
            password,
            address: req.body.address,
            phone: req.body.phone,

        })
        
        user.save().then(result => {
            return res.status(201).json(result)
        }).catch(err => {
            return res.status(400).json(err)
        })

    }catch(err){
        res.status(400).json(err);
    }
});

//Create a new user
router.post("/anonymous", async (req, res) => {
try{
    let user = new User ({
        name: "Anonymous"
    })
    
    user.save().then(result => {
        return res.status(201).json(result)
    }).catch(err => {
        return res.status(400).json(err)
    })

}catch(err){
    res.status(400).json(err);
}
});

router.post("/edit", async(req, res) => {
    try{
        
        let user = await User.findOne({_id: req.body.id})
        console.log(user);
        if(!user){
            res.status(404).json({error: "User not found."});
            return
        }
    
        if(req.body.name){
            user.name = req.body.name;
        }

        if(req.body.password){
            let salt = await bcrypt.genSalt(10); 
            let password = await bcrypt.hash(req.body.password, salt)
            user.password = password;
        }

        if(req.body.address){
            user.address = req.body.address;
        }

        if(req.body.phone){
            user.phone = req.body.phone;
        }

        user.save().then(result => {
            return res.status(200).json(result)
        }).catch(err => {
            return res.status(400).json(err)
        });

    }catch(err){
        res.status(400).json({error: err});
    }
});

module.exports = router;