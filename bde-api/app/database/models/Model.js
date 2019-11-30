module.exports = class Model
{
    constructor(tableName)
    {
        this._tableName = tableName;
        this._foreignKeys = [];
    }

    hydrate(values, modelType)
    {
        modelType.getKeys().map(key => {this[key] = values[key.substr(1)]});

        modelType.foreignKeys.map(fk =>
        {
            let fkModel = Object.create(fk.sourceModel);
            let attributes = [];

            Object.keys(values).map(key =>
            {
                let match = new RegExp(`^${fkModel.tableName}_(.+)`).exec(key);

                if(match !== undefined && match !== null)
                    attributes[match[1]] = values[key];
            });

            fkModel.hydrate(attributes, fk.sourceModel);

            this[fk.hostModelAttribute] = fkModel;
        });
    }

    static hydrateAll(modelType, values)
    {
        let models = [];

        values.map(set =>
        {
            let model = Object.create(modelType);
            model.hydrate(set, modelType);
            models.push(model);
        });

        return models;
    }

    toArray()
    {
       this.getKeys().map(key => this[key]);
    }

    getInsertionKeys()
    {
        return this.getKeys();
    }

    getKeys()
    {
        return Object.getOwnPropertyNames(this).filter(key =>
        {
            return  key !== '_tableName'   &&
                key !== '_foreignKeys' &&
                !(this.foreignKeys.reduce(
                    (contains, fk) => contains ? true : fk.hostModelAttribute === key, false
                ));
        });
    }

    get foreignKeys()
    {
        return this._foreignKeys;
    }

    set foreignKeys(value)
    {
        this._foreignKeys = value;
    }

    get tableName()
    {
        return this._tableName;
    }

    set tableName(value)
    {
        this._tableName = value;
    }
};