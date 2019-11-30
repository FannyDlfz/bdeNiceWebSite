let Model = require('./Model');

module.exports = class Role extends Model
{
    constructor(name = '', id = -1)
    {
        super('roles');
        this._id = id;
        this._name = name;
    }

    toArray()
    {
        return [this.name];
    }

    getInsertionKeys()
    {
        return ['_name'];
    }

    get id()
    {
        return this._id;
    }

    set id(value)
    {
        this._id = value;
    }

    get name()
    {
        return this._name;
    }

    set name(value)
    {
        this._name = value;
    }
};