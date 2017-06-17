@php($i = 0)
@php($post_max_id = 0)
@php($post_min_id = 0)
@foreach($posts as $post)
    @if($i == 0)
        @php($post_max_id = $post->id)
    @endif
    @php($post_min_id = $post->id)

    @include('widgets.post_detail.single_post')

    @php($i++)
@endforeach
@foreach($div_location as $location)
    <div class="post_data_filter_{{ $location }}">
        <input type="hidden" name="wall_type" value="{{ $wall_type }}" />
        <input type="hidden" name="list_type" value="{{ $list_type }}" />
        <input type="hidden" name="optional_id" value="{{ $optional_id }}" />
        <input type="hidden" name="limit" value="{{ $limit }}" />
        <input type="hidden" name="post_max_id" value="{{ $post_max_id }}" />
        <input type="hidden" name="post_min_id" value="{{ $post_min_id }}" />
    </div>
@endforeach