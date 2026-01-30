@extends('layouts.dashboard')

@section('title', 'Settings | ESIB SOCIAL')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Settings</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                <div class="list-group list-group-flush">
                    <a href="#general" class="list-group-item list-group-item-action active" data-bs-toggle="tab">
                        <i class="fas fa-cog me-2"></i>General
                    </a>
                    <a href="#notifications" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                        <i class="fas fa-bell me-2"></i>Notifications
                    </a>
                    <a href="#privacy" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                        <i class="fas fa-shield-alt me-2"></i>Privacy
                    </a>
                    <a href="#security" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                        <i class="fas fa-lock me-2"></i>Security
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="tab-content">
                <!-- General Settings -->
                <div class="tab-pane fade show active" id="general">
                    <div class="card border-0 shadow-lg mb-4 overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                        <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                            <h5 class="mb-0 fw-bold" style="color: #c2410c;">General Settings</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Language</label>
                                <select class="form-select">
                                    <option selected>English</option>
                                    <option>French</option>
                                    <option>Arabic</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold">Time Zone</label>
                                <select class="form-select">
                                    <option selected>UTC+0</option>
                                    <option>UTC+1</option>
                                    <option>UTC+2</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold">Date Format</label>
                                <select class="form-select">
                                    <option selected>MM/DD/YYYY</option>
                                    <option>DD/MM/YYYY</option>
                                    <option>YYYY-MM-DD</option>
                                </select>
                            </div>
                            <button class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Save Changes
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Notifications Settings -->
                <div class="tab-pane fade" id="notifications">
                    <div class="card border-0 shadow-lg mb-4 overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                        <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                            <h5 class="mb-0 fw-bold" style="color: #c2410c;">Notification Preferences</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                                <div>
                                    <h6 class="mb-1 fw-bold">Email Notifications</h6>
                                    <p class="text-muted small mb-0">Receive notifications via email</p>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" checked>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                                <div>
                                    <h6 class="mb-1 fw-bold">Push Notifications</h6>
                                    <p class="text-muted small mb-0">Receive push notifications</p>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" checked>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                                <div>
                                    <h6 class="mb-1 fw-bold">Course Updates</h6>
                                    <p class="text-muted small mb-0">Get notified about new courses</p>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" checked>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1 fw-bold">Session Reminders</h6>
                                    <p class="text-muted small mb-0">Remind me about upcoming sessions</p>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Privacy Settings -->
                <div class="tab-pane fade" id="privacy">
                    <div class="card border-0 shadow-lg mb-4 overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                        <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                            <h5 class="mb-0 fw-bold" style="color: #c2410c;">Privacy Settings</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                                <div>
                                    <h6 class="mb-1 fw-bold">Profile Visibility</h6>
                                    <p class="text-muted small mb-0">Make your profile visible to others</p>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                                <div>
                                    <h6 class="mb-1 fw-bold">Activity Tracking</h6>
                                    <p class="text-muted small mb-0">Allow activity tracking</p>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" checked>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1 fw-bold">Data Sharing</h6>
                                    <p class="text-muted small mb-0">Share anonymous usage data</p>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Security Settings -->
                <div class="tab-pane fade" id="security">
                    <div class="card border-0 shadow-lg mb-4 overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                        <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                            <h5 class="mb-0 fw-bold" style="color: #c2410c;">Security Settings</h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                For password changes, please visit your <a href="{{ route('profile') }}">Profile</a> page.
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                                <div>
                                    <h6 class="mb-1 fw-bold">Two-Factor Authentication</h6>
                                    <p class="text-muted small mb-0">Add an extra layer of security</p>
                                </div>
                                <button class="btn btn-outline-primary btn-sm">Enable</button>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                                <div>
                                    <h6 class="mb-1 fw-bold">Login History</h6>
                                    <p class="text-muted small mb-0">View your recent login activity</p>
                                </div>
                                <button class="btn btn-outline-secondary btn-sm">View</button>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1 fw-bold text-danger">Delete Account</h6>
                                    <p class="text-muted small mb-0">Permanently delete your account</p>
                                </div>
                                <button class="btn btn-outline-danger btn-sm">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
