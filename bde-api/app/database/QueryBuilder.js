module.exports = class QueryBuilder
{
    constructor(model)
    {
        this._model = model;
    }

    buildSelectQuery(values)
    {
        let query = `SELECT `;
        let keys = this.model.getKeys().map(key => this.model.tableName + '.' + key.substr(1));

        this.model.foreignKeys.map(fk =>
        {
            let tableName = fk.sourceModel.tableName;

            fk.sourceModel.getKeys().map(key =>
            {
                let field = key.substr(1);
                keys.push(`${tableName}.${field} AS ${tableName}_${field}`);
            });
        });

        for(let i in keys)
            query += keys[i] + (i < keys.length - 1 ? ', ' : ' FROM ');

        for(let i in this.model.foreignKeys)
            query += '(';

        query += this.model.tableName + ' ';

        this.model.foreignKeys.map(fk => { query += fk.generateSQLJoin() + ') '});

        if(values)
        {
            keys = Object.getOwnPropertyNames(values);

            if(keys.length > 0)
            {
                query += 'WHERE ';

                for(let i in keys)
                {
                    query += (i > 0 ? ' AND ' : '') + `${this.model.tableName}.${keys[i]} = ?`;
                }
            }
        }

        query += ';';

        return query;
    }

    buildInsertQuery(model)
    {
        let query = `INSERT INTO ${model.tableName} (`;

        let keys = this.model.getInsertionKeys().map(key => this.model.tableName + '.' + key.substr(1));

        this.model.foreignKeys.map(fk =>
        {
            let tableName = fk.hostModel.tableName;
            let field = fk.hostField;

            keys.push(`${tableName}.${field}`);
        });

        for(let i in keys)
            query += keys[i] + (i < keys.length - 1 ? ', ' : ') VALUES (');

        for(let i in keys)
            query += '?' + (i < keys.length - 1 ? ', ' : ');');

        return query;
    }

    buildUpdateQuery(model)
    {
        let query = `UPDATE ${model.tableName} SET `;

        let keys = this.model.getInsertionKeys().filter(key => model[key] != null).map(key => this.model.tableName + '.' + key.substr(1));

        console.log(keys);

        model.foreignKeys.map(fk =>
        {
            let tableName = fk.hostModel.tableName;
            let field = fk.hostField;

            if(model[fk.hostModelAttribute] != null)
                keys.push(`${tableName}.${field}`);
        });

        for(let i in keys)
                query += keys[i] + ' = ?' + (i < keys.length - 1 ? ', ' : ' WHERE id = ?;');

        console.log(query);

        return query;
    }

    buildDeleteQuery()
    {
        return `DELETE FROM ${this.model.tableName} WHERE id = ?`;
    }

    get model()
    {
        return this._model;
    }

    set model(value)
    {
        this._model = value;
    }
};