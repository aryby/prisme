<!-- Navigation -->
<header>
    <div class="container clearfix">
        <div class="row-fluid">
            <div class="span12">
                <h1 class="brandlogo">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('img/logo/lgo.jpg') }}" alt="" width="200" height="60">
                    </a>
                </h1>

                <div class="topinfo">
                    <p><br></p>
                    <div class="infophone">
                        <a href="#">The Multidisciplinary Research Laboratory in Social Engineering and Business
 Management (SIPRISME)</a>
                    </div>
                    <div class="infoaddress">
                        <p>17-18 December 2026 // Casablanca, Morocco</p>
                    </div>
                                            @include('partials.partnes-logo')

                </div>

                <div class="clearfix"></div>

                <div class="row-nav navbar">
                    <div class="navbar-inner">
                        <ul id="nav" class="nav">
                            <li><a href="{{ route('home') }}">HOME</a></li>

                            <li><a href="{{ route('committee') }}">COMMITTEE</a></li>

                            <li><a href="{{ route('important-dates') }}">IMPORTANT DATES</a></li>
                            <li class="divider-vertical"></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">CALL FOR PAPERS<b
                                        class="caret"></b></a>
                                <ul class="dropdown-menu js-activated" style="display: none;">
                                    <li><a href="{{ route('call-for-papers') }}">Call for Papers</a></li>
                                    {{-- create page public for author instruction --}}
                                    <li><a href="{{ route('author-instructions') }}">Author Instructions</a></li>
                                </ul>
                            </li>
                            <li class="divider-vertical"></li>

                            <li><a href="{{ route('submission') }}">SUBMISSION</a></li>
                            <li class="divider-vertical"></li>
                            <li><a href="{{ route('venue') }}">VENUE</a></li>
                            <li><a href="{{ route('contact') }}">CONTACT</a></li>
                            <li class="divider-vertical"></li>

                            @auth
                                {{-- Show dashboard link based on user role --}}
                                @if (auth()->user()->isAdmin())
                                    <li><a href="{{ route('filament.admin.pages.dashboard') }}">ADMIN DASHBOARD</a></li>
                                @elseif(auth()->user()->isAuthor())
                                    <li><a href="{{ route('filament.author.pages.dashboard') }}">AUTHOR DASHBOARD</a></li>
                                @endif

                                {{-- Show logout link for authenticated users --}}
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                        @csrf
                                        <button type="submit"
                                            style="background: none; border: none; color: inherit; cursor: pointer; padding: 0; text-decoration: none;">
                                            LOGOUT
                                        </button>
                                    </form>
                                </li>
                            @else
                                <li><a href="{{ route('login') }}">LOGIN</a></li>
                            @endauth

                            <li class="divider-vertical"></li>


                            <li class="divider-vertical"></li>


                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
