<style>
    .infopartners {
        display: flex;
        justify-content: start;
        align-items: start;
        gap: 20px;
        /* spacing between logos */
        flex-wrap: wrap;
        /* optional: allows wrapping on smaller screens */
    }

 


    .infopartners img {
        height: 40px;
        width: 50px;
        object-fit: contain;
    }

       /* Styles for desktop view only */
    @media screen and (min-width: 1024px) {
        .infopartners {
            padding-left: 120px;
        display: flex;
        justify-content: start;
        align-items: start;
        gap: 20px;
        /* spacing between logos */
        flex-wrap: wrap;
        /* optional: allows wrapping on smaller screens */
    }
    }
</style>

<div class="infopartners">
    @foreach ($partnerLogos as $partnerLogo)
        @if ($partnerLogo->url)
            <a href="{{ $partnerLogo->url }}" target="_blank" rel="noopener noreferrer">
                <img src="{{ $partnerLogo->image_url }}" width="50" height="40" alt="{{ $partnerLogo->name }}">
            </a>
        @else
            <img src="{{ $partnerLogo->image_url }}" width="50" height="40" alt="{{ $partnerLogo->name }}">
        @endif
    @endforeach
</div>
