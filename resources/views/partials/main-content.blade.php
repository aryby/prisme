<div class="row-fluid">
    <div class="span9">
        <div class="titleborder">
            <div>Presentation </div>
        </div>

        <div class="heightauto">
            <div class="list_carousel">
                <div class="clearfix"></div>

                <p align="justify">
                    <span class="text-info">
{{ \App\Models\PageContent::text('home.presentation') }}</span>




                </p>
                <p align="justify">
                    {{ \App\Models\PageContent::text('home.theme') }}
</p>
                <p align="justify">
                    {{ \App\Models\PageContent::text('home.audience') }}

                </p>




                <p class="alert-info"> Symposium Context and Objectives
                </p>
                <p align="justify">
                    
{!! nl2br(e(\App\Models\PageContent::text('home.context'))) !!}
<br>
{{ \App\Models\PageContent::text('home.central-question') }}</p>
 <br>           </div>
        </div>

        <div class="clearfix"></div>

        <div class="row-fluid top25">
            <div class="panel1">
                <div class="span11">
                    <h4 class="top0"><strong>Thematic Areas</strong></h4>
<p class="text-muted">
    {{ \App\Models\PageContent::text('home.thematic-intro') }}
</p>
                    @include('partials.thematic-areas')
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <div class="span3">
        <div class="titleborder">
            <div>IMPORTANT DATES</div>
        </div>

        <div class="accordion">
            <p>
                <strong>
                    @foreach ($importantDates as $importantDate)
                        @if ($loop->first)
                            <img src="{{ asset('img/logo/hot.gif') }}" width="20" height="20">
                        @endif
                        {{ $importantDate->title }}: <br>
                        <span class="STYLE3">{{ $importantDate->date }}</span>@if (!$loop->last)<br><br>@endif
                    @endforeach
                </strong>
            </p>
            <p>&nbsp;</p>
        </div>
    </div>
</div>
