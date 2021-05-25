
@if($flash_messages)
    @foreach($flash_messages as $flash)
        <div class="{{'alert alert-'.$flash['type']}}" role="alert">
            {{$flash['body']}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endforeach
@endif
