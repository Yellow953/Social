@extends('layouts.app')

@section('title', 'Terms of Service - Social Plus')

@section('content')
<div class="min-vh-100 py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-5">
                        <div class="text-center mb-5">
                            <i class="bi bi-file-text fs-1 mb-3" style="color: #ec682a;"></i>
                            <h1 class="fw-bold mb-2" style="color: #5c5c5c;">Terms of Service</h1>
                            <p class="text-muted">Last updated: {{ now()->format('F j, Y') }}</p>
                        </div>

                        <div class="content">
                            <section class="mb-5">
                                <h3 class="fw-bold mb-3" style="color: #5c5c5c;">1. Acceptance of Terms</h3>
                                <p class="text-muted">
                                    By accessing and using Social Plus, you accept and agree to be bound by the terms and provision of this agreement.
                                    If you do not agree to abide by the above, please do not use this service.
                                </p>
                            </section>

                            <section class="mb-5">
                                <h3 class="fw-bold mb-3" style="color: #5c5c5c;">2. Use License</h3>
                                <p class="text-muted mb-3">
                                    Permission is granted to temporarily access the materials on Social Plus for personal, non-commercial transitory viewing only.
                                    This is the grant of a license, not a transfer of title, and under this license you may not:
                                </p>
                                <ul class="text-muted">
                                    <li>Modify or copy the materials</li>
                                    <li>Use the materials for any commercial purpose or for any public display</li>
                                    <li>Attempt to decompile or reverse engineer any software contained on Social Plus</li>
                                    <li>Remove any copyright or other proprietary notations from the materials</li>
                                    <li>Download or attempt to download any content from the platform</li>
                                </ul>
                            </section>

                            <section class="mb-5">
                                <h3 class="fw-bold mb-3" style="color: #5c5c5c;">3. Subscription and Access</h3>
                                <p class="text-muted mb-3">
                                    Social Plus offers both free and premium (SOCIALPLUS) subscription options:
                                </p>
                                <ul class="text-muted">
                                    <li>Free accounts have limited access to content</li>
                                    <li>Premium SOCIALPLUS subscription provides access to all locked sessions and premium features</li>
                                    <li>Subscriptions require a valid username and password</li>
                                    <li>You are responsible for maintaining the confidentiality of your account credentials</li>
                                </ul>
                            </section>

                            <section class="mb-5">
                                <h3 class="fw-bold mb-3" style="color: #5c5c5c;">4. User Account</h3>
                                <p class="text-muted mb-3">
                                    When you create an account with us, you must provide information that is accurate, complete, and current at all times.
                                    You are responsible for safeguarding the password and for all activities that occur under your account.
                                </p>
                                <p class="text-muted">
                                    You agree not to share your account credentials with any third party. You must notify us immediately of any unauthorized use of your account.
                                </p>
                            </section>

                            <section class="mb-5">
                                <h3 class="fw-bold mb-3" style="color: #5c5c5c;">5. Content Protection</h3>
                                <p class="text-muted mb-3">
                                    All content on Social Plus is protected by copyright and other intellectual property laws. You agree:
                                </p>
                                <ul class="text-muted">
                                    <li>Not to take screenshots or record any content without authorization</li>
                                    <li>Not to share, distribute, or reproduce any content from the platform</li>
                                    <li>That your username may be watermarked on locked sessions for security purposes</li>
                                    <li>To respect the intellectual property rights of all content creators</li>
                                </ul>
                            </section>

                            <section class="mb-5">
                                <h3 class="fw-bold mb-3" style="color: #5c5c5c;">6. Device Restrictions</h3>
                                <p class="text-muted">
                                    Your account may only be accessed from one device at a time. Attempting to access your account from multiple devices simultaneously
                                    may result in automatic logout or account suspension.
                                </p>
                            </section>

                            <section class="mb-5">
                                <h3 class="fw-bold mb-3" style="color: #5c5c5c;">7. Prohibited Uses</h3>
                                <p class="text-muted mb-3">You may not use Social Plus:</p>
                                <ul class="text-muted">
                                    <li>In any way that violates any applicable national or international law or regulation</li>
                                    <li>To transmit, or procure the sending of, any advertising or promotional material</li>
                                    <li>To impersonate or attempt to impersonate the company, a company employee, another user, or any other person or entity</li>
                                    <li>In any way that infringes upon the rights of others, or in any way is illegal, threatening, fraudulent, or harmful</li>
                                </ul>
                            </section>

                            <section class="mb-5">
                                <h3 class="fw-bold mb-3" style="color: #5c5c5c;">8. Termination</h3>
                                <p class="text-muted">
                                    We may terminate or suspend your account and bar access to the service immediately, without prior notice or liability,
                                    under our sole discretion, for any reason whatsoever and without limitation, including but not limited to a breach of the Terms.
                                </p>
                            </section>

                            <section class="mb-5">
                                <h3 class="fw-bold mb-3" style="color: #5c5c5c;">9. Contact Information</h3>
                                <p class="text-muted">
                                    If you have any questions about these Terms of Service, please contact us through our support channels.
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
