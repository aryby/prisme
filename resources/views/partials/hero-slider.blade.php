<div class="row-fluid">
    <div class="camera_wrap pattern_4 camera_emboss" id="camera_wrap_4">
        @foreach ($slides as $slide)
            <div data-src="{{ $slide->image_url }}" data-title="{{ $slide->title }}">
                @if ($slide->title || $slide->caption)
                    <div class="camera_caption fadeFromBottom">
                        <div>
                            @if ($slide->title)
                                <h3>{{ $slide->title }}</h3>
                            @endif
                            @if ($slide->caption)
                                <p>{{ $slide->caption }}</p>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <div class="text-center">
        <img src="{{ asset('img/sha.png') }}" class="slidershadowcam" alt="">
    </div>
</div>
