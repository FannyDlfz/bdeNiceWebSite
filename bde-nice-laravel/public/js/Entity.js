class Entity
{
    hydrate(params)
    {
        Object.keys(params).map(key => { this[key] = params[key] });
        return this;
    }

    static hydrateAll(sets)
    {
        return sets.map(set => new Entity().hydrate(set));
    }
}
