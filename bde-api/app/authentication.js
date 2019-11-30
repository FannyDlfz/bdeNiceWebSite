const Repository  = require('./database/Repository');
const Dao         = require('./database/Dao');
const User        = require('./database/models/User');
const Role        = require('./database/models/Role');
const Center      = require('./database/models/Center');
const config      = require('./config');

module.exports = function(express, jwt)
{
    let router = express.Router();
    let repository = new Repository(new Dao().connection, new User());

    function logAuthentication(id, code, message)
    {
        console.log(`Attempt to authenticate with id ${id} | ${code} : ${message}`);
    }

    router.post('/', (req, res) =>
    {
        if(req.body)
        {
            repository.find(req.body)
                .then(result =>
                {
                    result = result[0];

                    if(result.password === req.body.password && result.role.id === 4)
                    {
                        let token = jwt.sign({ check: true }, config.secret, { expiresIn: 5 });

                        logAuthentication(req.body.id, 200, 'Success');

                        res.json({code: 200, message: 'Success', content: {token: token}});
                    }
                    else
                    {
                        logAuthentication(req.body.id, 401, 'Authentication failed');
                        res.json({code: 401, message: 'Authentication failed'});
                    }
                })
                .catch(e =>
                {
                    console.log(e);
                    logAuthentication(req.body.id, 404, 'User not found');
                    res.json({code: 404, message: 'User not found'})
                });
        }
        else
        {
            logAuthentication(req.body.id, 422, 'No credential given');
            res.json({code: 422, message: 'No credential given'})
        }
    });

    return router;
};