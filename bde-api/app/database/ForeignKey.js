module.exports = class ForeignKey
{
    constructor(sourceModel, sourceField, hostModel, hostField, hostModelAttribute)
    {
        this._sourceModel        = sourceModel;
        this._sourceField        = sourceField;
        this._hostModel          = hostModel;
        this._hostField          = hostField;
        this._hostModelAttribute = hostModelAttribute;
    }

    generateSQLJoin()
    {
        return `INNER JOIN ${this.sourceModel.tableName} ON ${this.sourceModel.tableName}.${this.sourceField} = ${this.hostModel.tableName}.${this.hostField} `;
    }

    get sourceModel()
    {
        return this._sourceModel;
    }

    set sourceModel(value)
    {
        this._sourceModel = value;
    }

    get sourceField()
    {
        return this._sourceField;
    }

    set sourceField(value)
    {
        this._sourceField = value;
    }

    get hostModel()
    {
        return this._hostModel;
    }

    set hostModel(value)
    {
        this._hostModel = value;
    }

    get hostField()
    {
        return this._hostField;
    }

    set hostField(value)
    {
        this._hostField = value;
    }

    get hostModelAttribute()
    {
        return this._hostModelAttribute;
    }

    set hostModelAttribute(value)
    {
        this._hostModelAttribute = value;
    }
};