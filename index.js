const express = require('express');
const app = express();
const port = 8080;

app.use( express.json())

app.listen(port, () => {
  console.log(`its alive on http://localhost:${port}`);
});

//req = incoming data res = outgoing data 
app.get('/tshirt',(req,res) => {
    res.status(200).send({
        tshirt:'👕',
        size:'large'
    })
    
});

// POST new tshirt
app.post('/tshirt/:id', (req, res) => {

    const{ id } = req.params;
    const{ logo } = req.body;

    if (!logo){
        res.status(418).send({message: 'We need a logo!'})
    }

    res.send({
        tshirt:`👕 with your ${logo} and ID of ${id}`,//` is andere soort mindblown
    });
});

/*
docomatie

RESTfull api are 
REST = Representational State Transfer

Gebruikt HTTP-methodes zoals

GET = data ophalen
POST = data aanmaken
PUT/PATCH = data aanpassen
DELETE = data verwijderen

Data wordt meestal verzonden in JSON-formaat
*/