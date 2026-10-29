@extends('layouts.app')

@section('title', 'About PRISME 2026 - The Multidisciplinary Research Laboratory in Social Engineering and Business
 Management (PRISME)')
@section('description', 'Learn about PRISME 2026, our mission, vision, and the exciting program we have planned for this premier international conference on digital economy and data innovation.')

@section('content')
<!-- Page Header -->
<div class="row-fluid">
    <div class="span12">
        <div class="titleborder">
            <div>About PRISME 2026</div>
        </div>
        <div class="text-center">
            <p class="lead">
                Discover the vision, mission, and exciting program that makes PRISME 2026 a premier destination for digital economy and data innovation research.
            </p>
        </div>
    </div>
</div>

<!-- Mission & Vision -->
<div class="row-fluid">
    <div class="span6">
        <div class="titleborder">
            <div>Our Mission</div>
        </div>
        <p class="lead">
            PRISME 2026 aims to bring together the world's leading researchers, academics, and industry professionals to explore and discuss the latest innovations in digital economy, smart business, and data innovation. We are committed to fostering collaboration, knowledge sharing, and the advancement of cutting-edge research that will shape our digital future.
        </p>
        <p>
            Our mission is to create a platform where groundbreaking ideas in digital transformation meet practical applications, where theoretical research transforms into real-world business solutions, and where the next generation of digital economy leaders can connect and collaborate.
        </p>
    </div>
    <div class="span6">
        <div class="well">
            <h3>Our Vision</h3>
            <p>
                To be the premier international conference that drives innovation in digital economy and data innovation, creating a global community of researchers and practitioners who are shaping the digital landscape of tomorrow.
            </p>
        </div>
    </div>
</div>

<!-- Conference Highlights -->
<div class="row-fluid">
    <div class="span12">
        <div class="titleborder">
            <div>Conference Highlights</div>
        </div>
        <p class="text-center lead">
            What makes PRISME 2026 a must-attend event for digital economy professionals and researchers
        </p>
    </div>
</div>

<div class="row-fluid">
    <div class="span4">
        <div class="well text-center">
            <h4>World-Class Speakers</h4>
            <p>Hear from leading experts and pioneers in digital economy, smart business, data innovation, and emerging technologies.</p>
        </div>
    </div>
    <div class="span4">
        <div class="well text-center">
            <h4>Cutting-Edge Research</h4>
            <p>Present and discuss the latest research findings and breakthrough innovations in digital economy and data innovation.</p>
        </div>
    </div>
    <div class="span4">
        <div class="well text-center">
            <h4>Networking Opportunities</h4>
            <p>Connect with peers, potential collaborators, and industry leaders from around the world.</p>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span4">
        <div class="well text-center">
            <h4>Interactive Workshops</h4>
            <p>Participate in hands-on workshops and tutorials led by industry experts and researchers.</p>
        </div>
    </div>
    <div class="span4">
        <div class="well text-center">
            <h4>Industry Exhibition</h4>
            <p>Explore the latest products and services from leading technology companies and startups.</p>
        </div>
    </div>
    <div class="span4">
        <div class="well text-center">
            <h4>Real-Time Impact</h4>
            <p>Be part of discussions that will influence the future direction of digital economy and innovation.</p>
        </div>
    </div>
</div>

<!-- Conference Program -->
<div class="row-fluid">
    <div class="span12">
        <div class="titleborder">
            <div>Conference Program</div>
        </div>
        <p class="text-center lead">
            A comprehensive program designed to maximize learning, networking, and collaboration
        </p>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="well">
            <h3>Day 1: Opening & Keynotes</h3>
            <p>Conference opening ceremony, keynote presentations from industry leaders, and plenary sessions covering the latest trends in digital economy and data innovation.</p>
            <ul>
                <li>Opening ceremony and welcome address</li>
                <li>Keynote presentations on digital transformation and smart business</li>
                <li>Plenary sessions on emerging technologies</li>
                <li>Welcome reception and networking</li>
            </ul>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="well">
            <h3>Day 2: Research Presentations</h3>
            <p>Parallel sessions featuring research presentations, panel discussions, and interactive workshops across all conference topics.</p>
            <ul>
                <li>Parallel technical sessions</li>
                <li>Panel discussions on digital economy trends</li>
                <li>Interactive workshops and tutorials</li>
                <li>Industry exhibition and poster sessions</li>
            </ul>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="well">
            <h3>Day 3: Innovation & Future</h3>
            <p>Focus on innovation showcases, startup presentations, and forward-looking discussions about the future of digital economy.</p>
            <ul>
                <li>Innovation showcases and startup presentations</li>
                <li>Future digital economy roadmap discussions</li>
                <li>Closing keynote and awards ceremony</li>
                <li>Conference dinner and networking</li>
            </ul>
        </div>
    </div>
</div>

<!-- Call to Action -->
<div class="row-fluid">
    <div class="span12">
        <div class="alert alert-info text-center">
            <h2>Join Us at PRISME 2026</h2>
            <p class="lead">
                Be part of the conversation that will shape the future of digital economy and data innovation. Register now and secure your spot at this premier international conference.
            </p>
            <p>
                <a href="{{ route('submission') }}" class="btn btn-primary btn-large">Submit Your Paper</a>
                <a href="{{ route('contact') }}" class="btn btn-default btn-large">Contact Us</a>
            </p>
        </div>
    </div>
</div>
@endsection