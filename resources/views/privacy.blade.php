@extends('layouts.app')

@section('title', 'Privacy Policy - Social Plus')

@section('content')
<div class="min-vh-100 py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-5">
                        <div class="text-center mb-5">
                            <i class="bi bi-shield-check fs-1 mb-3" style="color: #ec682a;"></i>
                            <h1 class="fw-bold mb-2" style="color: #5c5c5c;">Privacy Policy</h1>
                            <p class="text-muted">Last updated: {{ now()->format('F j, Y') }}</p>
                        </div>

                        <div class="content">
                            <section class="mb-5">
                                <h3 class="fw-bold mb-3" style="color: #5c5c5c;">1. Information We Collect</h3>
                                <p class="text-muted mb-3">
                                    We collect information that you provide directly to us when you:
                                </p>
                                <ul class="text-muted">
                                    <li>Create an account (name, email, phone number)</li>
                                    <li>Subscribe to SOCIALPLUS (username, password)</li>
                                    <li>Use our services (session access logs, device information)</li>
                                    <li>Contact us for support</li>
                                </ul>
                            </section>

                            <section class="mb-5">
                                <h3 class="fw-bold mb-3" style="color: #5c5c5c;">2. How We Use Your Information</h3>
                                <p class="text-muted mb-3">We use the information we collect to:</p>
                                <ul class="text-muted">
                                    <li>Provide, maintain, and improve our services</li>
                                    <li>Process your transactions and send related information</li>
                                    <li>Send you technical notices and support messages</li>
                                    <li>Respond to your comments and questions</li>
                                    <li>Monitor and analyze usage patterns and trends</li>
                                    <li>Detect and prevent fraud and abuse</li>
                                    <li>Enforce security measures including watermarking and device restrictions</li>
                                </ul>
                            </section>

                            <section class="mb-5">
                                <h3 class="fw-bold mb-3" style="color: #5c5c5c;">3. Data Logging and Analytics</h3>
                                <p class="text-muted mb-3">
                                    We maintain detailed logs of user activity including:
                                </p>
                                <ul class="text-muted">
                                    <li>Session access times and duration</li>
                                    <li>Which sessions and courses you access</li>
                                    <li>Device information and IP addresses</li>
                                    <li>Screenshot detection events (if enabled)</li>
                                </ul>
                                <p class="text-muted">
                                    This data is used for security purposes, platform improvement, and to ensure compliance with our terms of service.
                                </p>
                            </section>

                            <section class="mb-5">
                                <h3 class="fw-bold mb-3" style="color: #5c5c5c;">4. Watermarking</h3>
                                <p class="text-muted">
                                    For security purposes, locked sessions may display your username as a watermark.
                                    This watermark is designed to be visible but not interfere with content readability.
                                    This helps protect intellectual property and prevent unauthorized sharing.
                                </p>
                            </section>

                            <section class="mb-5">
                                <h3 class="fw-bold mb-3" style="color: #5c5c5c;">5. Device Restrictions</h3>
                                <p class="text-muted">
                                    To ensure account security and prevent unauthorized access, your account may only be accessed from one device at a time.
                                    We track device information to enforce this restriction and protect your account.
                                </p>
                            </section>

                            <section class="mb-5">
                                <h3 class="fw-bold mb-3" style="color: #5c5c5c;">6. Information Sharing</h3>
                                <p class="text-muted mb-3">
                                    We do not sell, trade, or rent your personal information to third parties. We may share your information only:
                                </p>
                                <ul class="text-muted">
                                    <li>With your explicit consent</li>
                                    <li>To comply with legal obligations</li>
                                    <li>To protect our rights and prevent fraud</li>
                                    <li>With service providers who assist in operating our platform (under strict confidentiality agreements)</li>
                                </ul>
                            </section>

                            <section class="mb-5">
                                <h3 class="fw-bold mb-3" style="color: #5c5c5c;">7. Data Security</h3>
                                <p class="text-muted">
                                    We implement appropriate technical and organizational security measures to protect your personal information against
                                    unauthorized access, alteration, disclosure, or destruction. However, no method of transmission over the Internet
                                    or electronic storage is 100% secure.
                                </p>
                            </section>

                            <section class="mb-5">
                                <h3 class="fw-bold mb-3" style="color: #5c5c5c;">8. Your Rights</h3>
                                <p class="text-muted mb-3">You have the right to:</p>
                                <ul class="text-muted">
                                    <li>Access your personal information</li>
                                    <li>Correct inaccurate information</li>
                                    <li>Request deletion of your account and data</li>
                                    <li>Opt-out of certain data collection practices</li>
                                    <li>Request a copy of your data</li>
                                </ul>
                            </section>

                            <section class="mb-5">
                                <h3 class="fw-bold mb-3" style="color: #5c5c5c;">9. Cookies and Tracking</h3>
                                <p class="text-muted">
                                    We use cookies and similar tracking technologies to track activity on our platform and hold certain information.
                                    You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent.
                                </p>
                            </section>

                            <section class="mb-5">
                                <h3 class="fw-bold mb-3" style="color: #5c5c5c;">10. Changes to This Policy</h3>
                                <p class="text-muted">
                                    We may update our Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy
                                    on this page and updating the "Last updated" date.
                                </p>
                            </section>

                            <section class="mb-5">
                                <h3 class="fw-bold mb-3" style="color: #5c5c5c;">11. Contact Us</h3>
                                <p class="text-muted">
                                    If you have any questions about this Privacy Policy, please contact us through our support channels.
                                </p>
                            </section>
                        </div>

                        <div class="text-center mt-5">
                            <a href="{{ route('register') }}" class="btn text-white" style="background: #ec682a; border: none;">
                                <i class="bi bi-arrow-left me-2"></i>Back to Registration
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
