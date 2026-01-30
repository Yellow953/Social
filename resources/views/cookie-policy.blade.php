@extends('layouts.policy')

@section('title', 'Cookie Policy | ESIB SOCIAL')
@section('meta_description', 'How ESIB SOCIAL uses cookies and similar technologies for sessions, preferences, and analytics.')
@section('og_title', 'Cookie Policy | ESIB SOCIAL')

@section('policy')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-lg overflow-hidden" style="border-left: 4px solid #3b82f6 !important;">
            <div class="card-body p-5">
                @include('partials.policy.header', ['title' => 'Cookie Policy'])

                <div class="content">
                    <section class="mb-5">
                        <h3 class="fw-bold mb-3" style="color: #5c5c5c;">1. What Are Cookies</h3>
                        <p class="text-muted">
                            Cookies are small text files that are placed on your device when you visit our website. They are widely used to make
                            websites work more efficiently and to provide information to the owners of the site. We use cookies and similar
                            technologies to improve your experience, analyze usage, and support security.
                        </p>
                    </section>

                    <section class="mb-5">
                        <h3 class="fw-bold mb-3" style="color: #5c5c5c;">2. How We Use Cookies</h3>
                        <p class="text-muted mb-3">We use cookies for the following purposes:</p>
                        <ul class="text-muted">
                            <li><strong>Essential cookies</strong> — Required for the website to function (e.g. login session, security)</li>
                            <li><strong>Preference cookies</strong> — Remember your settings and choices (e.g. language, sidebar state)</li>
                            <li><strong>Analytics cookies</strong> — Help us understand how visitors use the platform (e.g. pages visited, duration)</li>
                            <li><strong>Security cookies</strong> — Support authentication, device recognition, and fraud prevention</li>
                        </ul>
                    </section>

                    <section class="mb-5">
                        <h3 class="fw-bold mb-3" style="color: #5c5c5c;">3. Types of Cookies We Use</h3>
                        <p class="text-muted mb-3">
                            Our platform may use first-party cookies (set by us) and, where applicable, third-party cookies (e.g. from analytics
                            or embedded content). Session cookies are temporary and deleted when you close your browser; persistent cookies
                            remain for a set period or until you delete them.
                        </p>
                    </section>

                    <section class="mb-5">
                        <h3 class="fw-bold mb-3" style="color: #5c5c5c;">4. Managing Cookies</h3>
                        <p class="text-muted">
                            You can control and/or delete cookies as you wish via your browser settings. You can delete all cookies that are
                            already on your device and you can set most browsers to prevent them from being placed. If you do this, you may
                            have to manually adjust some preferences every time you visit, and some features may not function as intended.
                        </p>
                    </section>

                    <section class="mb-5">
                        <h3 class="fw-bold mb-3" style="color: #5c5c5c;">5. Updates</h3>
                        <p class="text-muted">
                            We may update this Cookie Policy from time to time to reflect changes in our practices or for legal reasons.
                            We will post the updated policy on this page and update the "Last updated" date.
                        </p>
                    </section>

                    <section class="mb-5">
                        <h3 class="fw-bold mb-3" style="color: #5c5c5c;">6. Contact</h3>
                        <p class="text-muted">
                            If you have questions about our use of cookies, please contact us through our support channels. For more on how we
                            handle personal data, see our <a href="{{ route('privacy') }}" style="color: #ec682a;">Privacy Policy</a>.
                        </p>
                    </section>
                </div>

                @include('partials.policy.footer-actions')
            </div>
        </div>
    </div>
</div>
@endsection
