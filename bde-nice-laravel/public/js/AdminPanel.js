class AdminPanel
{
    constructor(name, fillable)
    {
        this._name = name;
        this.getPaginate(1);
        this.fillable = fillable;
        $('.search-bar button').bind('click', e =>
        {
            e.preventDefault();
            let keywords = $('.search-bar input').prop('value');
            this.search(keywords);
        });
    }

    request(url, method, params)
    {
        $.ajax(
        {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            accepts: {
                json: 'application/json'
            },
            url: url,
            method: method,
            data: params
        })
        .done(data =>
        {
            this.entities = Entity.hydrateAll(data[this.name].data);
            this.refresh();
        });
    }

    search(keywords)
    {
        this.request('/' + this.name + '/search', 'POST', { search: keywords });
    }

    getPaginate(page)
    {
        this.request('/admin/' + this.name + '/list', 'GET', { page: page });
    }

    refresh()
    {
        $('.table tbody').empty();

        this.entities.map(entity =>
        {
            let row = $('<tr></tr>');

            this.fillable.map( key =>
            {
                row.append('<td>' + entity[key] + '</td>')
            });

            row.append('<td><a href="/' + this.name + '/' + entity.id + '/edit" class="far fa-edit"></a></td>');
            row.append('<td><a href="/' + this.name + '/' + entity.id + '/delete" class="fas fa-trash"></a></td>');

            $('.table tbody').append(row);
        });
    }

    get name()
    {
        return this._name;
    }

    set name(value)
    {
        this._name = value;
    }
}
