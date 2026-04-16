@extends('layouts.dashboard')

@section('title', 'Académique | ESIB SOCIAL')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Académique</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2 class="fw-bold mb-1" style="color: #c2410c;"><i class="fas fa-graduation-cap me-2" style="color: #ec682a;"></i>Académique</h2>
        <p class="text-muted mb-0">Choisissez une année, une filière, un semestre, un cours, puis ouvrez un matériel pour le consulter avec filigrane.</p>
    </div>

    @if(!auth()->user()->hasActiveSubscription() && !auth()->user()->isAdmin())
        <div class="alert alert-warning mb-4">
            <div class="d-flex align-items-center">
                <i class="fas fa-lock me-3 fs-4"></i>
                <div class="flex-grow-1">
                    <h6 class="mb-1 fw-bold">Abonnement requis pour les matériels verrouillés</h6>
                    <p class="mb-0">Un abonnement SOCIALPLUS actif est nécessaire. <a href="{{ route('subscriptions.create') }}" class="alert-link">Souscrire</a> et attendre l'approbation.</p>
                </div>
            </div>
        </div>
    @endif

    <!-- 1. Years -->
    <section id="section-years" class="mb-5">
        <h5 class="fw-bold mb-4" style="color: #c2410c;"><i class="fas fa-calendar-alt me-2" style="color: #ec682a;"></i>1. Choisir une année</h5>
        <div id="years-loading" class="text-center py-5 text-muted">
            <div class="spinner-border me-2" role="status"></div> Chargement des années...
        </div>
        <div id="years-cards" class="academique-step-cards academique-years-wrap row g-4 d-none"></div>
    </section>

    <!-- 2. Majors -->
    <section id="section-majors" class="mb-5 d-none">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
            <h5 class="fw-bold mb-0" style="color: #c2410c;"><i class="fas fa-user-graduate me-2" style="color: #ec682a;"></i>2. Choisir une filière pour <span id="majors-year-label"></span></h5>
            <a href="#" id="back-from-majors" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i> Back</a>
        </div>
        <div id="majors-cards" class="academique-step-cards academique-majors-wrap row g-4"></div>
    </section>

    <!-- 3. Semester -->
    <section id="section-semester" class="mb-5 d-none">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
            <h5 class="fw-bold mb-0" style="color: #c2410c;"><i class="fas fa-layer-group me-2" style="color: #ec682a;"></i>3. Choisir un semestre pour <span id="semester-year-label"></span> – <span id="semester-major-label"></span></h5>
            <a href="#" id="back-from-semester" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i> Back</a>
        </div>
        <div id="semester-cards" class="row g-4" style="max-width:100%;width:100%;"></div>
    </section>

    <!-- 4. Courses -->
    <section id="section-courses" class="mb-5 d-none">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
            <h5 class="fw-bold mb-0" style="color: #c2410c;"><i class="fas fa-book-open me-2" style="color: #ec682a;"></i>4. Cours pour <span id="courses-year-label"></span> – <span id="courses-major-label"></span> (Semestre <span id="courses-semester-label"></span>)</h5>
            <a href="#" id="back-from-courses" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i> Back</a>
        </div>
        <div id="courses-loading" class="text-center py-5 text-muted d-none">
            <div class="spinner-border me-2" role="status"></div> Chargement des cours...
        </div>
        <div id="courses-cards" class="row g-3 g-md-4"></div>
        <div id="courses-empty" class="d-none"></div>
    </section>

    <!-- 5. Materials -->
    <section id="section-materials" class="mb-5 d-none">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
            <h5 class="fw-bold mb-0" style="color: #c2410c;"><i class="fas fa-file-alt me-2" style="color: #ec682a;"></i>5. Matériel pour <span id="materials-course-label"></span></h5>
            <a href="#" id="back-from-materials" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i> Back</a>
        </div>
        <div id="materials-loading" class="text-center py-5 text-muted d-none">
            <div class="spinner-border me-2" role="status"></div> Chargement du matériel...
        </div>
        <p id="materials-empty" class="text-muted text-center py-4 d-none">Aucun matériel pour ce cours.</p>
        <div id="materials-grid" class="row g-4"></div>
    </section>
</div>

<script>
(function() {
    const yearsUrl = @json(route('academique.years'));
    const coursesUrl = @json(route('academique.courses'));
    const materialsUrl = @json(route('academique.materials'));
    const materialsBaseUrl = @json(url('/materials'));
    const userYear = @json($userYear);
    const userMajor = @json($userMajor);
    const allYears = ['Sup', 'Spé', '1e', '2e', '3e'];
    const yearsList = userYear ? [userYear] : allYears;
    const majorsList = userMajor ? [userMajor] : @json($majors);
    const hasSubscription = @json(auth()->user()->hasActiveSubscription() || auth()->user()->isAdmin());

    const sectionYears = document.getElementById('section-years');
    const yearsLoading = document.getElementById('years-loading');
    const yearsCards = document.getElementById('years-cards');
    const sectionMajors = document.getElementById('section-majors');
    const majorsYearLabel = document.getElementById('majors-year-label');
    const majorsCards = document.getElementById('majors-cards');
    const backFromMajors = document.getElementById('back-from-majors');
    const sectionSemester = document.getElementById('section-semester');
    const semesterYearLabel = document.getElementById('semester-year-label');
    const semesterMajorLabel = document.getElementById('semester-major-label');
    const semesterCards = document.getElementById('semester-cards');
    const backFromSemester = document.getElementById('back-from-semester');
    const sectionCourses = document.getElementById('section-courses');
    const coursesYearLabel = document.getElementById('courses-year-label');
    const coursesMajorLabel = document.getElementById('courses-major-label');
    const coursesSemesterLabel = document.getElementById('courses-semester-label');
    const backFromCourses = document.getElementById('back-from-courses');
    const coursesLoading = document.getElementById('courses-loading');
    const coursesCards = document.getElementById('courses-cards');
    const coursesEmpty = document.getElementById('courses-empty');
    const sectionMaterials = document.getElementById('section-materials');
    const materialsCourseLabel = document.getElementById('materials-course-label');
    const backFromMaterials = document.getElementById('back-from-materials');
    const materialsLoading = document.getElementById('materials-loading');
    const materialsEmpty = document.getElementById('materials-empty');
    const materialsGrid  = document.getElementById('materials-grid');

    let selectedYear = null;
    let selectedMajor = null;
    let selectedSemester = null;
    let selectedCourseId = null;
    let selectedCourseName = null;

    function csrfHeaders() {
        const token = document.querySelector('meta[name="csrf-token"]');
        return {
            'X-CSRF-TOKEN': token ? token.getAttribute('content') : '',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        };
    }

    function escapeHtml(s) {
        const div = document.createElement('div');
        div.textContent = s;
        return div.innerHTML;
    }

    backFromMajors.addEventListener('click', function(e) {
        e.preventDefault();
        selectedYear = null;
        selectedMajor = null;
        selectedSemester = null;
        sectionMajors.classList.add('d-none');
        sectionSemester.classList.add('d-none');
        sectionCourses.classList.add('d-none');
        sectionMaterials.classList.add('d-none');
        sectionYears.classList.remove('d-none');
        majorsCards.innerHTML = '';
    });

    backFromSemester.addEventListener('click', function(e) {
        e.preventDefault();
        goBackToMajors();
    });

    backFromCourses.addEventListener('click', function(e) {
        e.preventDefault();
        goBackToSemester();
    });

    function goBackToMajors() {
        selectedSemester = null;
        selectedCourseId = null;
        sectionSemester.classList.add('d-none');
        sectionCourses.classList.add('d-none');
        sectionMaterials.classList.add('d-none');
        sectionMajors.classList.remove('d-none');
        semesterCards.innerHTML = '';
        coursesCards.innerHTML = '';
        document.getElementById('courses-empty').classList.add('d-none');
    }

    function goBackToSemester() {
        selectedCourseId = null;
        sectionCourses.classList.add('d-none');
        sectionMaterials.classList.add('d-none');
        sectionSemester.classList.remove('d-none');
        coursesCards.innerHTML = '';
        document.getElementById('courses-empty').classList.add('d-none');
    }

    backFromMaterials.addEventListener('click', function(e) {
        e.preventDefault();
        selectedCourseId = null;
        sectionMaterials.classList.add('d-none');
        sectionCourses.classList.remove('d-none');
        materialsGrid.innerHTML = '';
    });

    // Load years on page load — filtered to user's year if set
    (function() {
        yearsLoading.classList.add('d-none');
        yearsCards.classList.remove('d-none');
        yearsCards.innerHTML = '';
        yearsList.forEach(year => {
                const col = document.createElement('div');
                col.className = 'col-6 col-md';
                const card = document.createElement('a');
                card.href = '#';
                card.className = 'card border-0 shadow h-100 text-decoration-none academique-year-card academique-step-card';
                card.style.borderLeft = '4px solid #ec682a';
                card.dataset.year = year;
                card.addEventListener('click', function(e) {
                    e.preventDefault();
                    selectedYear = year;
                    selectedMajor = null;
                    selectedSemester = null;
                    selectedCourseId = null;
                    document.querySelectorAll('.academique-year-card').forEach(el => el.classList.remove('border-primary'));
                    this.classList.add('border-primary');
                    sectionYears.classList.add('d-none');
                    sectionSemester.classList.add('d-none');
                    sectionCourses.classList.add('d-none');
                    sectionMaterials.classList.add('d-none');
                    sectionMajors.classList.remove('d-none');
                    majorsYearLabel.textContent = year;
                    renderMajors();
                });
                card.innerHTML = '<div class="card-body text-center d-flex flex-column align-items-center justify-content-center py-5 px-3" style="min-height:240px;"><div class="academique-step-icon academique-year-icon mb-4"><i class="fas fa-calendar-alt" style="color: #ec682a;"></i></div><h2 class="fw-bold mb-1 text-dark">' + escapeHtml(year) + '</h2><small class="text-muted fs-6">Année</small></div>';
                col.appendChild(card);
                yearsCards.appendChild(col);
            });
        })();

    function renderMajors() {
        majorsCards.innerHTML = '';
        (majorsList || []).forEach(major => {
            const col = document.createElement('div');
            col.className = 'col-12 col-sm-6 col-lg-3';
            const card = document.createElement('a');
            card.href = '#';
            card.className = 'card border-0 shadow h-100 text-decoration-none academique-major-card academique-step-card';
            card.style.borderLeft = '4px solid #ec682a';
            card.dataset.major = major;
            card.addEventListener('click', function(e) {
                e.preventDefault();
                selectedMajor = major;
                selectedSemester = null;
                selectedCourseId = null;
                document.querySelectorAll('.academique-major-card').forEach(el => el.classList.remove('border-primary'));
                this.classList.add('border-primary');
                sectionMajors.classList.add('d-none');
                sectionCourses.classList.add('d-none');
                sectionMaterials.classList.add('d-none');
                sectionSemester.classList.remove('d-none');
                semesterYearLabel.textContent = selectedYear;
                semesterMajorLabel.textContent = major;
                renderSemester();
            });
            card.innerHTML = '<div class="card-body text-center d-flex flex-column align-items-center justify-content-center py-5 px-3" style="min-height:200px;"><div class="academique-step-icon academique-major-icon mb-4"><i class="fas fa-user-graduate" style="color: #ec682a;"></i></div><h5 class="fw-bold mb-0 text-dark academique-major-title" title="' + escapeHtml(major) + '">' + escapeHtml(major) + '</h5></div>';
            col.appendChild(card);
            majorsCards.appendChild(col);
        });
    }

    function renderSemester() {
        semesterCards.innerHTML = '';
        ['1', '2'].forEach(function(sem) {
            const col = document.createElement('div');
            col.className = 'col-6';
            const card = document.createElement('a');
            card.href = '#';
            card.className = 'card border-0 shadow h-100 text-decoration-none academique-semester-card academique-step-card';
            card.style.borderLeft = '4px solid #ec682a';
            card.dataset.semester = sem;
            card.addEventListener('click', function(e) {
                e.preventDefault();
                selectedSemester = sem;
                document.querySelectorAll('.academique-semester-card').forEach(el => el.classList.remove('border-primary'));
                this.classList.add('border-primary');
                sectionSemester.classList.add('d-none');
                sectionMaterials.classList.add('d-none');
                sectionCourses.classList.remove('d-none');
                coursesYearLabel.textContent = selectedYear;
                coursesMajorLabel.textContent = selectedMajor;
                coursesSemesterLabel.textContent = sem;
                loadCourses(selectedYear, selectedMajor, sem);
            });
            card.innerHTML = '<div class="card-body text-center d-flex flex-column align-items-center justify-content-center py-5 px-3" style="min-height:240px;"><div class="academique-step-icon academique-semester-icon mb-4"><i class="fas fa-layer-group" style="color: #ec682a;"></i></div><h2 class="fw-bold mb-1 text-dark">Semestre ' + sem + '</h2><small class="text-muted fs-6">Semester ' + sem + '</small></div>';
            col.appendChild(card);
            semesterCards.appendChild(col);
        });
    }

    function loadCourses(year, major, semester) {
        coursesLoading.classList.remove('d-none');
        coursesEmpty.classList.add('d-none');
        coursesCards.innerHTML = '';

        fetch(coursesUrl + '?year=' + encodeURIComponent(year) + '&major=' + encodeURIComponent(major) + '&semester=' + encodeURIComponent(semester), { headers: csrfHeaders(), credentials: 'same-origin' })
            .then(r => r.json())
            .then(data => {
                coursesLoading.classList.add('d-none');
                if (!data.courses || data.courses.length === 0) {
                    const subHint = !hasSubscription
                        ? '<p class="text-muted small mt-2 mb-0"><i class="fas fa-lock me-1"></i>Certains cours peuvent nécessiter un <a href="{{ route('subscriptions.create') }}" class="alert-link">abonnement SOCIALPLUS</a>.</p>'
                        : '';
                    coursesEmpty.innerHTML = '<div class="academique-empty-state text-center py-5 px-4 mx-auto" style="max-width: 420px;"><div class="academique-empty-icon mb-4"><i class="fas fa-book-open" style="color: #ec682a;"></i></div><h5 class="fw-bold mb-2" style="color: #5c5c5c;">Aucun cours pour le moment</h5><p class="text-muted mb-0">Aucun cours n\'est disponible pour cette année, filière et semestre. Choisissez un autre semestre ou une autre filière.</p>' + subHint + '<a href="#" id="courses-empty-back-semester" class="btn btn-outline-secondary mt-3"><i class="fas fa-arrow-left me-2"></i>Back</a></div>';
                    coursesEmpty.classList.remove('d-none');
                    document.getElementById('courses-empty-back-semester').addEventListener('click', function(ev) { ev.preventDefault(); goBackToSemester(); });
                    return;
                }
                coursesEmpty.classList.add('d-none');
                data.courses.forEach(course => {
                    const col = document.createElement('div');
                    col.className = 'col-12 col-sm-6 col-lg-4';
                    const card = document.createElement('a');
                    card.href = '#';
                    card.className = 'card border-0 shadow-sm h-100 text-decoration-none academique-course-card';
                    card.style.borderLeft = '4px solid #ec682a';
                    card.dataset.courseId = course.id;
                    card.dataset.courseName = course.name || '';
                    card.addEventListener('click', function(e) {
                        e.preventDefault();
                        selectedCourseId = course.id;
                        selectedCourseName = course.name || ('Cours #' + course.id);
                        materialsCourseLabel.textContent = selectedCourseName;
                        sectionCourses.classList.add('d-none');
                        sectionMaterials.classList.remove('d-none');
                        loadMaterials(course.id);
                    });
                    const extraBadge = course.is_extra ? '<span class="badge bg-warning text-dark mt-2" style="font-size:0.7rem;"><i class="fas fa-star me-1"></i>Extra</span>' : '';
                    card.innerHTML = '<div class="card-body text-center d-flex flex-column align-items-center justify-content-center py-5 px-3" style="min-height:200px;"><div class="academique-step-icon academique-course-icon mb-4"><i class="fas fa-book-open" style="color: #ec682a;"></i></div><h5 class="fw-bold mb-1 text-dark" title="' + escapeHtml(course.name) + '">' + escapeHtml(course.name) + '</h5>' + (course.code ? '<small class="text-muted fs-6">' + escapeHtml(course.code) + '</small>' : '') + extraBadge + '</div>';
                    col.appendChild(card);
                    coursesCards.appendChild(col);
                });
            })
            .catch(() => {
                coursesLoading.classList.add('d-none');
                coursesEmpty.classList.remove('d-none');
                coursesEmpty.innerHTML = '<div class="academique-empty-state text-center py-5 px-4 mx-auto" style="max-width: 420px;"><div class="academique-empty-icon mb-4"><i class="fas fa-exclamation-triangle text-danger"></i></div><h5 class="fw-bold mb-2" style="color: #5c5c5c;">Erreur de chargement</h5><p class="text-muted mb-0">Impossible de charger les cours. Réessayez plus tard.</p></div>';
            });
    }

    const materialTypeMeta = {
        cours:           { label: 'Cours',           icon: 'fa-book',           color: '#2563eb', bg: '#dbeafe' },
        tp:              { label: 'TP',               icon: 'fa-flask',          color: '#16a34a', bg: '#dcfce7' },
        td:              { label: 'TD',               icon: 'fa-pencil-alt',     color: '#7c3aed', bg: '#ede9fe' },
        tc:              { label: 'TC',               icon: 'fa-clipboard',      color: '#ec682a', bg: '#fff3ed' },
        resume:          { label: 'Résumé',           icon: 'fa-compress-alt',   color: '#0891b2', bg: '#cffafe' },
        partiel:         { label: 'Partiel',          icon: 'fa-file-alt',       color: '#d97706', bg: '#fef9c3' },
        final:           { label: 'Final',            icon: 'fa-graduation-cap', color: '#dc2626', bg: '#fee2e2' },
        video_recording: { label: 'Enregistrement',  icon: 'fa-video',          color: '#4f46e5', bg: '#e0e7ff' },
    };

    function loadMaterials(courseId) {
        materialsLoading.classList.remove('d-none');
        materialsEmpty.classList.add('d-none');
        materialsGrid.innerHTML = '';

        fetch(materialsUrl + '?course_id=' + courseId, { headers: csrfHeaders(), credentials: 'same-origin' })
            .then(r => r.json())
            .then(data => {
                materialsLoading.classList.add('d-none');
                if (!data.materials || data.materials.length === 0) {
                    materialsEmpty.innerHTML = !hasSubscription
                        ? 'Aucun matériel accessible pour ce cours. <a href="{{ route('subscriptions.create') }}" class="alert-link">Abonnez-vous</a> pour débloquer les matériels verrouillés.'
                        : 'Aucun matériel pour ce cours.';
                    materialsEmpty.classList.remove('d-none');
                    return;
                }

                data.materials.forEach(m => {
                    const meta    = materialTypeMeta[m.type] || { label: m.type, icon: 'fa-file', color: '#6b7280', bg: '#f3f4f6' };
                    const summary = m.media_summary || {};
                    const desc    = (m.description || '').substring(0, 100);

                    const mediaBadges = [
                        summary.pdf   ? `<span class="material-media-badge pdf"><i class="fas fa-file-pdf"></i> ${summary.pdf}</span>`   : '',
                        summary.video ? `<span class="material-media-badge video"><i class="fas fa-video"></i> ${summary.video}</span>`   : '',
                        summary.image ? `<span class="material-media-badge img"><i class="fas fa-image"></i> ${summary.image}</span>`     : '',
                    ].filter(Boolean).join('');

                    const col  = document.createElement('div');
                    col.className = 'col-12 col-sm-6 col-lg-4';

                    const locked = m.is_locked && !m.can_access;

                    col.innerHTML = `
                        <div class="material-card h-100 ${locked ? 'material-card--locked' : ''}">
                            <div class="material-card-header">
                                <div class="material-type-icon" style="background:${meta.bg};color:${meta.color};">
                                    <i class="fas ${meta.icon}"></i>
                                </div>
                                <span class="material-type-label" style="background:${meta.bg};color:${meta.color};">${meta.label}</span>
                                ${m.is_locked ? '<span class="material-lock-badge"><i class="fas fa-lock"></i></span>' : ''}
                            </div>
                            <div class="material-card-body">
                                <h5 class="material-title">${escapeHtml(m.title)}</h5>
                                ${desc ? `<p class="material-desc">${escapeHtml(desc)}${(m.description||'').length > 100 ? '…' : ''}</p>` : ''}
                                ${mediaBadges ? `<div class="material-media-badges">${mediaBadges}</div>` : ''}
                            </div>
                            <div class="material-card-footer">
                                ${m.can_access
                                    ? `<a href="${materialsBaseUrl}/${m.id}" class="material-btn-access"><i class="fas fa-eye me-2"></i>Voir le matériel</a>`
                                    : `<span class="material-btn-locked"><i class="fas fa-lock me-2"></i>Abonnement requis</span>`}
                            </div>
                        </div>`;

                    materialsGrid.appendChild(col);
                });
            })
            .catch(() => {
                materialsLoading.classList.add('d-none');
                materialsEmpty.classList.remove('d-none');
                materialsEmpty.textContent = 'Erreur de chargement';
            });
    }
})();
</script>

@push('styles')
<style>
/* Step 1 & 2: fuller card design */
.academique-step-cards {
    max-width: 900px;
}
.academique-years-wrap {
    max-width: 100% !important;
    width: 100% !important;
}
.academique-years-wrap .col-md {
    flex: 0 0 20%;
    max-width: 20%;
}
.academique-year-icon {
    width: 96px !important;
    height: 96px !important;
    font-size: 2.6rem !important;
    border-radius: 20px !important;
}
@media (max-width: 767px) {
    .academique-years-wrap .col-6 { flex: 0 0 50%; max-width: 50%; }
}
.academique-step-card {
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%) !important;
    border-radius: 12px !important;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.academique-step-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,0.12) !important;
}
.academique-step-icon {
    width: 56px;
    height: 56px;
    border-radius: 12px;
    background: linear-gradient(135deg, rgba(236, 104, 42, 0.12) 0%, rgba(194, 65, 12, 0.08) 100%);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}
.academique-major-icon {
    width: 96px !important;
    height: 96px !important;
    font-size: 2.6rem !important;
    border-radius: 20px !important;
}
.academique-majors-wrap {
    max-width: 100% !important;
    width: 100% !important;
}
.academique-semester-icon {
    width: 96px !important;
    height: 96px !important;
    font-size: 2.6rem !important;
    border-radius: 20px !important;
}
.academique-course-icon {
    width: 72px !important;
    height: 72px !important;
    font-size: 2rem !important;
    border-radius: 16px !important;
}
.academique-major-title {
    font-size: 0.95rem;
    line-height: 1.35;
    word-break: break-word;
}
.academique-year-card:hover,
.academique-major-card:hover,
.academique-semester-card:hover,
.academique-course-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,0.12) !important;
}
.academique-year-card,
.academique-major-card,
.academique-semester-card,
.academique-course-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

/* ── Material cards ───────────────────────────────────────────── */
.material-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: transform .2s ease, box-shadow .2s ease;
    border-left: 4px solid #ec682a;
}
.material-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(0,0,0,.10);
}
.material-card--locked {
    border-left-color: #9ca3af;
    opacity: .85;
}
.material-card-header {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 16px 18px 12px;
    border-bottom: 1px solid #f1f5f9;
}
.material-type-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
}
.material-type-label {
    font-size: .75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .04em;
    border-radius: 6px;
    padding: 3px 8px;
}
.material-lock-badge {
    margin-left: auto;
    color: #9ca3af;
    font-size: .9rem;
}
.material-card-body {
    padding: 14px 18px;
    flex: 1;
}
.material-title {
    font-size: 1rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 6px;
    line-height: 1.35;
}
.material-desc {
    font-size: .83rem;
    color: #6b7280;
    margin-bottom: 10px;
    line-height: 1.5;
}
.material-media-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
}
.material-media-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: .75rem;
    font-weight: 600;
    padding: 3px 9px;
    border-radius: 999px;
}
.material-media-badge.pdf   { background: #fee2e2; color: #dc2626; }
.material-media-badge.video { background: #dbeafe; color: #2563eb; }
.material-media-badge.img   { background: #dcfce7; color: #16a34a; }
.material-card-footer {
    padding: 12px 18px;
    border-top: 1px solid #f1f5f9;
}
.material-btn-access {
    display: block;
    text-align: center;
    padding: 10px;
    background: linear-gradient(135deg, #ec682a, #c2410c);
    color: #fff;
    font-weight: 600;
    font-size: .875rem;
    border-radius: 10px;
    text-decoration: none;
    transition: opacity .15s;
}
.material-btn-access:hover { opacity: .88; color: #fff; }
.material-btn-locked {
    display: block;
    text-align: center;
    padding: 10px;
    background: #f3f4f6;
    color: #9ca3af;
    font-weight: 600;
    font-size: .875rem;
    border-radius: 10px;
}

/* Empty state when no courses for year+major */
#courses-empty {
    margin-top: 5rem;
}
.academique-empty-state {
    background: linear-gradient(180deg, rgba(236, 104, 42, 0.06) 0%, transparent 100%);
    border-radius: 16px;
    border: 2px dashed rgba(236, 104, 42, 0.3);
}
.academique-empty-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto;
    border-radius: 20px;
    background: linear-gradient(135deg, rgba(236, 104, 42, 0.12) 0%, rgba(194, 65, 12, 0.06) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
}
</style>
@endpush
@endsection
