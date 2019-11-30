let Model      = require('./Model');
let Role       = require('./Role');
let Center     = require('./Center');
let ForeignKey = require('../ForeignKey');

module.exports = class User extends Model
{
    constructor(name = '', email = '', password = '', role={}, center={}, id = -1,  email_verified_at = '', created_at = '', last_updated_at = '')
    {
        super('users');

        this._id                = id;
        this._name              = name;
        this._email             = email;
        this._password          = password;
        this._email_verified_at = email_verified_at;
        this._created_at        = created_at;
        this._last_updated_at   = last_updated_at;
        this._role              = role;
        this._center            = center;

        this.foreignKeys.push(new ForeignKey(new Role(), 'id', this, 'role_id', '_role'));
        this.foreignKeys.push(new ForeignKey(new Center(), 'id', this, 'center_id', '_center'));
    }

    toArray()
    {
        return [this.name, this.email, this.password];
    }

    getInsertionKeys()
    {
        return ['_name', '_email', '_password'];
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

    get email()
    {
        return this._email;
    }

    set email(value)
    {
        this._email = value;
    }

    get password()
    {
        return this._password;
    }

    set password(value)
    {
        this._password = value;
    }

    get email_verified_at()
    {
        return this._email_verified_at;
    }

    set email_verified_at(value)
    {
        this._email_verified_at = value;
    }

    get created_at()
    {
        return this._created_at;
    }

    set created_at(value)
    {
        this._created_at = value;
    }

    get last_updated_at()
    {
        return this._last_updated_at;
    }

    set last_updated_at(value)
    {
        this._last_updated_at = value;
    }

    get role()
    {
        return this._role;
    }

    set role(value)
    {
        this._role = value;
    }

    get center()
    {
        return this._center;
    }

    set center(value)
    {
        this._center = value;
    }
};