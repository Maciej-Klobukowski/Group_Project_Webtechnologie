import axios from 'axios';

axios.post('/api/user.php', {
  username: 'testuser',
  password: 'testpass'
}).then(response => {
  console.log(response.data);
}).catch(error => {
  console.error(error);
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