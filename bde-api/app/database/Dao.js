let mysql = require('mysql');

module.exports = class Dao
{
    constructor()
    {
        this._connection = mysql.createConnection(
        {
            host: 'db-restapi',
            port: '3306',
            user: 'bde',
            password: 'secret-password12345',
            database: 'bde-api'
        });
    }

    get connection()
    {
        return this._connection;
    }

    set connection(value)
    {
        this._connection = value;
    }
};