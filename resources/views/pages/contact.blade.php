@extends(auth()->check() && auth()->user()->role === 'user' ? 'layouts.customer' : 'layouts.public')

@section('title', 'Contact Us — MarketLink')

@section('content')

    <section class="products-page-header py-4">
        <div class="container">
            <nav class="small mb-2 breadcrumb-ml">
                <a href="{{ url('/') }}">Home</a> / <span>Contact Us</span>
            </nav>
            <h2 class="mb-1">Contact Us</h2>
            <p class="text-muted mb-0">We'd love to hear from you.</p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-4 align-items-stretch">

                <div class="col-lg-5">
                    <div class="contact-card h-100">
                        <span class="section-tag">Get In Touch</span>
                        <h4 class="mt-2 mb-3">MarketLink Team</h4>

                        <div class="contact-info-item">
                            <i class="bi bi-people-fill"></i>
                            <span>MarketLink — TechWiz7 / Aptech Project Team</span>
                        </div>
                        <div class="contact-info-item">
                            <i class="bi bi-envelope-fill"></i>
                            <span>support@marketlink.example</span>
                        </div>
                        <div class="contact-info-item">
                            <i class="bi bi-telephone-fill"></i>
                            <span>+92 300 0000000</span>
                        </div>
                        <div class="contact-info-item">
                            <i class="bi bi-geo-alt-fill"></i>
                            <span>Karachi, Sindh, Pakistan</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="contact-map h-100 d-flex flex-column">
                        <h6 class="filter-card-title">Find Us</h6>
                        <div class="rounded overflow-hidden border flex-grow-1" style="min-height: 300px;">
                            <iframe
                                src="https://www.google.com/maps?q=Karachi,+Pakistan&output=embed"
                                width="100%"
                                height="100%"
                                style="border:0; min-height: 300px;"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                        <p class="small text-muted mt-2 mb-0">
                            Placeholder location — replace the address in this embed with your team's actual address.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
