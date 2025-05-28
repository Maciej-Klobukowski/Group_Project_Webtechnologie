const express = require('express');
const app = express();
const port = 8080;

//req = incoming data res = outgoing data 
app.get('/tshirt',(req,res) => {
    res.status(200).send({
        tshirt:'👕',
        size:'large'
    })
    
});


app.listen(port, () => {
  console.log(`Server running at http://localhost:${port}`);
});
