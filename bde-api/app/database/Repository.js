let Model = require('./models/Model');
let QueryBuilder = require('./QueryBuilder');

module.exports = class Repository
{
    constructor(connection, modelType)
    {
        this.connection   = connection;
        this.modelType    = modelType;
        this.queryBuilder = new QueryBuilder(modelType);
    }

    findAll()
    {
        return new Promise((resolve, reject) =>
        {
            this.connection.query(this.queryBuilder.buildSelectQuery(), (err, rows) =>
            {
                if (err) reject(err); else resolve(Model.hydrateAll(this.modelType, rows));
            });
        });
    }

    find(query)
    {
        return new Promise((resolve, reject) =>
        {
            this.connection.query(this.queryBuilder.buildSelectQuery(query), Object.values(query), (err, rows) =>
            {
                if (err) reject(err); else resolve(Model.hydrateAll(this.modelType, rows));
            });
        });
    }

    store(model)
    {
        return new Promise((resolve, reject) =>
        {
            let values = model.toArray();

            model.foreignKeys.map(fk =>
            {
                let fkModel = model[fk.hostModelAttribute];
                values.push(fkModel['_' + fk.sourceField])
            });

            console.log(values);

            this.connection.query(this.queryBuilder.buildInsertQuery(model), values, (err) =>
            {
                if (err) reject(err); else resolve();
            });
        });
    }

    update(model)
    {
        return new Promise((resolve, reject) =>
        {
            let values = [model.name, model.center.id, model.id];

            /*model.foreignKeys.map(fk =>
            {
                let fkModel = model[fk.hostModelAttribute];
                if(fkModel != null)
                    values.push(fkModel['_' + fk.sourceField])
            });*/

            //values.push(model.id);

            this.connection.query(this.queryBuilder.buildUpdateQuery(model), values, (err) =>
            {
                if (err) reject(err); else resolve();
            });
        });
    }

    delete(id)
    {
        return new Promise((resolve, reject) =>
        {
            this.connection.query(this.queryBuilder.buildDeleteQuery(), [id], (err) =>
            {
                if (err) reject(err); else resolve();
            });
        });
    }
};