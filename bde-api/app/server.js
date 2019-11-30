const express              = require('express');
const bodyParser           = require('body-parser');
const jwt                  = require('jsonwebtoken');
const morgan               = require('morgan');
const router               = require('./router')(express, jwt);
const Dao                  = require('./database/Dao');
const User                 = require('./database/models/User');
const Role                 = require('./database/models/Role');
const Center               = require('./database/models/Center');
const Repository           = require('./database/Repository');
const authenticationRouter = require('./authentication')(express, jwt);

let app = express();

app.use(morgan('dev'));
app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json());
app.use('/authenticate', authenticationRouter);
app.use('/api', router);

setTimeout(() => app.listen(3000, "0.0.0.0", () =>
{
   console.log("Successfully started REST API.");
}), 12000);
