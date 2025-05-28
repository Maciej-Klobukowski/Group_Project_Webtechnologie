const app = require('express')();
const port = 8080;

//req = incoming data res = outgoing data 
app.get('/tshirt',(req,res) => {
    res.status(200).send({
        tshirt:'👕',
        size:'large'
    })
    
});


