@extends('layouts.policy')

@section('title', 'Terms of Service | ESIB SOCIAL')
@section('meta_description', 'ESIB SOCIAL Terms of Service. Rules for using our learning platform, subscriptions, content protection, and account use.')
@section('og_title', 'Terms of Service | ESIB SOCIAL')

@section('policy')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-lg overflow-hidden" style="border-left: 4px solid #ec682a !important;">
            <div class="card-body p-5">
                @include('partials.policy.header', ['title' => 'Terms of Service'])

                <div class="content">
                    <section class="mb-5">
                        <h3 class="fw-bold mb-3" style="color: #5c5c5c;">1. Acceptance of Terms</h3>
                        <p class="text-muted">
                            By accessing and using ESIB SOCIAL, you accept and agree to be bound by the terms and provision of this agreement.
                            If you do not agree to abide by the above, please do not use this service.
                        </p>
                    </section>

                    <section class="mb-5">
                        <h3 class="fw-bold mb-3" style="color: #5c5c5c;">2. Use License</h3>
                        <p class="text-muted mb-3">
                            Permission is granted to temporarily access the materials on ESIB SOCIAL for personal, non-commercial transitory viewing only.
                            This is the grant of a license, not a transfer of title, and under this license you may not:
                        </p>
                        <ul class="text-muted">
                            <li>Modify or copy the materials</li>
                            <li>Use the materials for any commercial purpose or for any public display</li>
                            <li>Attempt to decompile or reverse engineer any software contained on ESIB SOCIAL</li>
                            <li>Remove any copyright or other proprietary notations from the materials</li>
                            <li>Download or attempt to download any content from the platform</li>
                        </ul>
                    </section>

                    <section class="mb-5">
                        <h3 class="fw-bold mb-3" style="color: #5c5c5c;">3. Subscription and Access</h3>
                        <p class="text-muted mb-3">
                            ESIB SOCIAL offers both free and premium (SOCIALPLUS) subscription options:
                        </p>
                        <ul class="text-muted">
                            <li>Free accounts have limited access to content</li>
                            <li>Premium SOCIALPLUS subscription provides access to all locked materials and premium features</li>
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
                            All content on ESIB SOCIAL is protected by copyright and other intellectual property laws. You agree:
                        </p>
                        <ul class="text-muted">
                            <li>Not to take screenshots or record any content without authorization</li>
                            <li>Not to share, distribute, or reproduce any content from the platform</li>
                            <li>That your username may be watermarked on locked materials for security purposes</li>
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
                        <p class="text-muted mb-3">You may not use ESIB SOCIAL:</p>
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

                @include('partials.policy.footer-actions')
            </div>
        </div>
    </div>
</div>
@endsection
