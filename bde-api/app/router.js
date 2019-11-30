const Repository  = require('./database/Repository');
const Dao         = require('./database/Dao');
const User        = require('./database/models/User');
const Role        = require('./database/models/Role');
const Center      = require('./database/models/Center');
const config      = require('./config');

module.exports = function(express, jwt)
{
    let router = express.Router();
    let userRepository   = new Repository(new Dao().connection, new User());
    let roleRepository   = new Repository(new Dao().connection, new Role());
    let centerRepository = new Repository(new Dao().connection, new Center());

    function generateSuccessJson(content)
    {
        return { code: 200, message: 'Success', content: content };
    }

    router.use((req, res, next) =>
    {
        let token = req.headers['access-token'];

        if (token)
        {
            jwt.verify(token, config.secret, (err, decoded) =>
            {
                if (err)
                {
                    return res.json({code: 401, message: 'Invalid token'});
                }
                else
                {
                    req.decoded = decoded;
                    next();
                }
            });
        }
        else
        {
            res.json({code: 422, message: 'No token provided'});
        }
    });



    router.route('/users')
    .get(function(req, res)
    {
        if(req.query)
        {
            userRepository.find(req.query)
                .then(result => res.json(generateSuccessJson(result)))
                .catch(e => { console.log(e); res.json({ code: 500, message: 'Internal server error' }) });
        }
        else
        {
            userRepository.findAll()
                .then(result => res.json(generateSuccessJson(result)))
                .catch(e => { console.log(e); res.json({ code: 500, message: 'Internal server error' }) });
        }
    })
    .post(function(req, res)
    {
        userRepository.store
        (
            new User(req.body.name, req.body.email, req.body.password, new Role('', req.body.role), new Center('', req.body.center))
        ).then(result => res.json(generateSuccessJson(result)))
            .catch(e => { console.log(e); res.json({ code: 500, message: 'Internal server error' }) });
    })
    .put(function(req, res)
    {
        userRepository.update
        (
            new User(req.body.name, null, null, null, new Center('', req.body.center), req.body.id)
        ).then(result => res.json(generateSuccessJson(result)))
            .catch(e => { console.log(e); res.json({ code: 500, message: 'Internal server error' }) });
    })
    .delete(function(req, res)
    {
        console.log(req.query.id);
        userRepository.delete
        (
            req.query.id
        ).then(result => res.json(generateSuccessJson(result)))
            .catch(e => { console.log(e); res.json({ code: 500, message: 'Internal server error' }) });
    });



    router.route('/roles')
        .get(function(req, res)
        {
            if(req.query)
            {
                roleRepository.find(req.query)
                    .then(result => res.json(generateSuccessJson(result)))
                    .catch(e => { console.log(e); res.json({ code: 500, message: 'Internal server error' }) });
            }
            else
            {
                roleRepository.findAll()
                    .then(result => res.json(generateSuccessJson(result)))
                    .catch(e => { console.log(e); res.json({ code: 500, message: 'Internal server error' }) });
            }
        })
        .post(function(req, res)
        {
            roleRepository.store
            (
                new Role(req.body.name)
            ).then(result => res.json(generateSuccessJson(result)))
                .catch(e => { console.log(e); res.json({ code: 500, message: 'Internal server error' }) });
        })
        .put(function(req, res)
        {
            userRepository.update
            (
                new Role(req.body.name, req.body.id)
            ).then(result => res.json(generateSuccessJson(result)))
                .catch(e => { console.log(e); res.json({ code: 500, message: 'Internal server error' }) });
        })
        .delete(function(req, res)
        {
            console.log(req.query.id);
            userRepository.delete
            (
                req.query.id
            ).then(result => res.json(generateSuccessJson(result)))
                .catch(e => { console.log(e); res.json({ code: 500, message: 'Internal server error' }) });
        });
    
    

    router.route('/centers')
        .get(function(req, res)
        {
            if(req.query)
            {
                centerRepository.find(req.query)
                    .then(result => res.json(generateSuccessJson(result)))
                    .catch(e => { console.log(e); res.json({ code: 500, message: 'Internal server error' }) });
            }
            else
            {
                centerRepository.findAll()
                    .then(result => res.json(generateSuccessJson(result)))
                    .catch(e => { console.log(e); res.json({ code: 500, message: 'Internal server error' }) });
            }
        })
        .post(function(req, res)
        {
            centerRepository.store
            (
                new Center(req.body.name)
            ).then(result => res.json(generateSuccessJson(result)))
                .catch(e => { console.log(e); res.json({ code: 500, message: 'Internal server error' }) });
        })
        .put(function(req, res)
        {
            userRepository.update
            (
                new Center(req.body.name, req.body.id)
            ).then(result => res.json(generateSuccessJson(result)))
                .catch(e => { console.log(e); res.json({ code: 500, message: 'Internal server error' }) });
        })
        .delete(function(req, res)
        {
            console.log(req.query.id);
            userRepository.delete
            (
                req.query.id
            ).then(result => res.json(generateSuccessJson(result)))
                .catch(e => { console.log(e); res.json({ code: 500, message: 'Internal server error' }) });
        });

    return router;
};