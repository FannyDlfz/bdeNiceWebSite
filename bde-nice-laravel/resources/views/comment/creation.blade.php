    <form class="full-width-form" method="POST" action="{{ route('comments.store') }}" enctype="multipart/form-data">
        {{ csrf_field() }}

        {!! $errors->first( $attribute_name , '<p class="alert alert-danger">:message</p>') !!}
        <input type="hidden" name="{{ $attribute_name }}" value="{{ $attribute_id }}" />
        <br/>

        {!! $errors->first('text', '<p class="alert alert-danger">:message</p>') !!}
        <div class="input-group">
            <label id="form-comment" class="input-group-addon comment-label" for="form-commentaire">Commentaire</label>
            <textarea id="form-commentaire" class="form-control comment-area" name="text" required></textarea>
        </div>
        <br/>
        <input class="btn btn-lg btn-filled" type="submit" value="Valider"/>
    </form>
