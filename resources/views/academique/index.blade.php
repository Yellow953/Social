@extends('layouts.dashboard')

@section('title', 'Académique | ESIB SOCIAL')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Académique</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2 class="fw-bold mb-1" style="color: #c2410c;"><i class="fas fa-graduation-cap me-2" style="color: #ec682a;"></i>Académique</h2>
        <p class="text-muted mb-0">Choisissez une année, une filière, un cours, puis ouvrez un matériel pour le consulter avec filigrane.</p>
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
            <a href="#" id="back-from-majors" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i> Changer d'année</a>
        </div>
        <div id="majors-cards" class="academique-step-cards academique-majors-wrap row g-4"></div>
    </section>

    <!-- 3. Courses -->
    <section id="section-courses" class="mb-5 d-none">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
            <h5 class="fw-bold mb-0" style="color: #c2410c;"><i class="fas fa-book-open me-2" style="color: #ec682a;"></i>3. Cours pour <span id="courses-year-label"></span> – <span id="courses-major-label"></span></h5>
            <a href="#" id="back-from-courses" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i> Changer de filière</a>
        </div>
        <div id="courses-loading" class="text-center py-5 text-muted d-none">
            <div class="spinner-border me-2" role="status"></div> Chargement des cours...
        </div>
        <div id="courses-cards" class="row g-3 g-md-4"></div>
        <div id="courses-empty" class="d-none"></div>
    </section>

    <!-- 4. Materials -->
    <section id="section-materials" class="mb-5 d-none">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
            <h5 class="fw-bold mb-0" style="color: #c2410c;"><i class="fas fa-file-alt me-2" style="color: #ec682a;"></i>4. Matériel pour <span id="materials-course-label"></span></h5>
            <a href="#" id="back-from-materials" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i> Changer de cours</a>
        </div>
        <div id="materials-loading" class="text-center py-5 text-muted d-none">
            <div class="spinner-border me-2" role="status"></div> Chargement du matériel...
        </div>
        <p id="materials-empty" class="text-muted text-center py-4 d-none">Aucun matériel pour ce cours.</p>
        <div id="materials-list-wrap" class="card border-0 shadow-sm d-none" style="border-left: 4px solid #ec682a !important;">
            <ul id="materials-list" class="list-group list-group-flush"></ul>
        </div>
    </section>
</div>

<script>
(function() {
    const yearsUrl = @json(route('academique.years'));
    const coursesUrl = @json(route('academique.courses'));
    const materialsUrl = @json(route('academique.materials'));
    const materialsBaseUrl = @json(url('/materials'));
    const majorsList = @json($majors);

    const sectionYears = document.getElementById('section-years');
    const yearsLoading = document.getElementById('years-loading');
    const yearsCards = document.getElementById('years-cards');
    const sectionMajors = document.getElementById('section-majors');
    const majorsYearLabel = document.getElementById('majors-year-label');
    const majorsCards = document.getElementById('majors-cards');
    const backFromMajors = document.getElementById('back-from-majors');
    const sectionCourses = document.getElementById('section-courses');
    const coursesYearLabel = document.getElementById('courses-year-label');
    const coursesMajorLabel = document.getElementById('courses-major-label');
    const backFromCourses = document.getElementById('back-from-courses');
    const coursesLoading = document.getElementById('courses-loading');
    const coursesCards = document.getElementById('courses-cards');
    const coursesEmpty = document.getElementById('courses-empty');
    const sectionMaterials = document.getElementById('section-materials');
    const materialsCourseLabel = document.getElementById('materials-course-label');
    const backFromMaterials = document.getElementById('back-from-materials');
    const materialsLoading = document.getElementById('materials-loading');
    const materialsEmpty = document.getElementById('materials-empty');
    const materialsListWrap = document.getElementById('materials-list-wrap');
    const materialsList = document.getElementById('materials-list');

    let selectedYear = null;
    let selectedMajor = null;
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
        sectionMajors.classList.add('d-none');
        sectionCourses.classList.add('d-none');
        sectionMaterials.classList.add('d-none');
        sectionYears.classList.remove('d-none');
        majorsCards.innerHTML = '';
    });

    backFromCourses.addEventListener('click', function(e) {
        e.preventDefault();
        goBackToMajors();
    });

    function goBackToMajors() {
        selectedCourseId = null;
        sectionCourses.classList.add('d-none');
        sectionMaterials.classList.add('d-none');
        sectionMajors.classList.remove('d-none');
        coursesCards.innerHTML = '';
        document.getElementById('courses-empty').classList.add('d-none');
    }

    backFromMaterials.addEventListener('click', function(e) {
        e.preventDefault();
        selectedCourseId = null;
        sectionMaterials.classList.add('d-none');
        sectionCourses.classList.remove('d-none');
        materialsList.innerHTML = '';
    });

    // Load years on page load (always all 5)
    fetch(yearsUrl, { headers: csrfHeaders(), credentials: 'same-origin' })
        .then(r => r.json())
        .then(data => {
            yearsLoading.classList.add('d-none');
            yearsCards.classList.remove('d-none');
            yearsCards.innerHTML = '';
            (data.years || []).forEach(year => {
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
                    selectedCourseId = null;
                    document.querySelectorAll('.academique-year-card').forEach(el => el.classList.remove('border-primary'));
                    this.classList.add('border-primary');
                    sectionYears.classList.add('d-none');
                    sectionCourses.classList.add('d-none');
                    sectionMaterials.classList.add('d-none');
                    sectionMajors.classList.remove('d-none');
                    majorsYearLabel.textContent = year;
                    renderMajors();
                });
                card.innerHTML = '<div class="card-body text-center d-flex flex-column align-items-center justify-content-center py-5 px-4"><div class="academique-step-icon mb-3"><i class="fas fa-calendar-alt" style="color: #ec682a;"></i></div><h5 class="fw-bold mb-1 text-dark">' + escapeHtml(year) + '</h5><small class="text-muted">Année</small></div>';
                col.appendChild(card);
                yearsCards.appendChild(col);
            });
        })
        .catch(() => {
            yearsLoading.innerHTML = '<span class="text-danger">Erreur de chargement</span>';
        });

    function renderMajors() {
        majorsCards.innerHTML = '';
        (majorsList || []).forEach(major => {
            const col = document.createElement('div');
            col.className = 'col-12 col-sm-6 col-lg-4';
            const card = document.createElement('a');
            card.href = '#';
            card.className = 'card border-0 shadow h-100 text-decoration-none academique-major-card academique-step-card';
            card.style.borderLeft = '4px solid #ec682a';
            card.dataset.major = major;
            card.addEventListener('click', function(e) {
                e.preventDefault();
                selectedMajor = major;
                selectedCourseId = null;
                document.querySelectorAll('.academique-major-card').forEach(el => el.classList.remove('border-primary'));
                this.classList.add('border-primary');
                sectionMajors.classList.add('d-none');
                sectionMaterials.classList.add('d-none');
                sectionCourses.classList.remove('d-none');
                coursesYearLabel.textContent = selectedYear;
                coursesMajorLabel.textContent = major;
                loadCourses(selectedYear, major);
            });
            card.innerHTML = '<div class="card-body d-flex align-items-center gap-3 py-4 px-4"><div class="academique-step-icon flex-shrink-0"><i class="fas fa-user-graduate" style="color: #ec682a;"></i></div><h6 class="fw-bold mb-0 text-dark academique-major-title" title="' + escapeHtml(major) + '">' + escapeHtml(major) + '</h6></div>';
            col.appendChild(card);
            majorsCards.appendChild(col);
        });
    }

    function loadCourses(year, major) {
        coursesLoading.classList.remove('d-none');
        coursesEmpty.classList.add('d-none');
        coursesCards.innerHTML = '';

        fetch(coursesUrl + '?year=' + encodeURIComponent(year) + '&major=' + encodeURIComponent(major), { headers: csrfHeaders(), credentials: 'same-origin' })
            .then(r => r.json())
            .then(data => {
                coursesLoading.classList.add('d-none');
                if (!data.courses || data.courses.length === 0) {
                    coursesEmpty.innerHTML = '<div class="academique-empty-state text-center py-5 px-4 mx-auto" style="max-width: 420px;"><div class="academique-empty-icon mb-4"><i class="fas fa-book-open" style="color: #ec682a;"></i></div><h5 class="fw-bold mb-2" style="color: #5c5c5c;">Aucun cours pour le moment</h5><p class="text-muted mb-4 mb-md-0">Aucun cours n\'est disponible pour cette année et cette filière. Choisissez une autre filière ou une autre année pour voir les cours.</p><a href="#" id="courses-empty-back-major" class="btn btn-outline-secondary mt-3"><i class="fas fa-arrow-left me-2"></i>Changer de filière</a></div>';
                    coursesEmpty.classList.remove('d-none');
                    document.getElementById('courses-empty-back-major').addEventListener('click', function(ev) { ev.preventDefault(); goBackToMajors(); });
                    return;
                }
                coursesEmpty.classList.add('d-none');
                data.courses.forEach(course => {
                    const col = document.createElement('div');
                    col.className = 'col-6 col-sm-6 col-md-4 col-lg-3';
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
                    card.innerHTML = '<div class="card-body"><i class="fas fa-book-open mb-2" style="color: #ec682a;"></i><h6 class="fw-bold mb-1 text-dark text-truncate" title="' + escapeHtml(course.name) + '">' + escapeHtml(course.name) + '</h6>' + (course.code ? '<small class="text-muted">' + escapeHtml(course.code) + '</small>' : '') + '</div>';
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

    function loadMaterials(courseId) {
        materialsLoading.classList.remove('d-none');
        materialsEmpty.classList.add('d-none');
        materialsListWrap.classList.add('d-none');
        materialsList.innerHTML = '';

        fetch(materialsUrl + '?course_id=' + courseId, { headers: csrfHeaders(), credentials: 'same-origin' })
            .then(r => r.json())
            .then(data => {
                materialsLoading.classList.add('d-none');
                if (!data.materials || data.materials.length === 0) {
                    materialsEmpty.classList.remove('d-none');
                    return;
                }
                materialsListWrap.classList.remove('d-none');
                data.materials.forEach(m => {
                    const li = document.createElement('li');
                    li.className = 'list-group-item d-flex align-items-center justify-content-between gap-3 py-3';
                    const desc = (m.description || '').substring(0, 80);
                    const summary = m.media_summary || {};
                    const types = [];
                    if (summary.pdf) types.push('<span class="badge bg-danger me-1" title="PDF"><i class="fas fa-file-pdf me-1"></i>' + summary.pdf + '</span>');
                    if (summary.video) types.push('<span class="badge bg-primary me-1" title="Video"><i class="fas fa-video me-1"></i>' + summary.video + '</span>');
                    if (summary.image) types.push('<span class="badge bg-success me-1" title="Image"><i class="fas fa-image me-1"></i>' + summary.image + '</span>');
                    const typesHtml = types.length ? '<div class="d-flex flex-wrap gap-1 mt-1">' + types.join('') + '</div>' : '';
                    li.innerHTML = '<div class="flex-grow-1 min-w-0"><strong class="d-block">' + escapeHtml(m.title) + '</strong>' + (desc ? '<small class="text-muted d-block">' + escapeHtml(desc) + ((m.description || '').length > 80 ? '…' : '') + '</small>' : '') + typesHtml + '</div>';
                    if (m.can_access) {
                        const link = document.createElement('a');
                        link.href = materialsBaseUrl + '/' + m.id;
                        link.className = 'btn btn-sm btn-primary flex-shrink-0';
                        link.innerHTML = '<i class="fas fa-eye me-1"></i> Voir';
                        li.appendChild(link);
                    } else {
                        const span = document.createElement('span');
                        span.className = 'badge bg-secondary flex-shrink-0';
                        span.innerHTML = '<i class="fas fa-lock me-1"></i> Verrouillé';
                        span.title = 'Abonnement requis';
                        li.appendChild(span);
                    }
                    materialsList.appendChild(li);
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
.academique-years-wrap .col-md {
    flex: 0 0 20%;
    max-width: 20%;
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
.academique-major-card .academique-step-icon {
    width: 48px;
    height: 48px;
    font-size: 1.25rem;
}
.academique-major-title {
    font-size: 0.95rem;
    line-height: 1.35;
    word-break: break-word;
}
.academique-year-card:hover,
.academique-major-card:hover,
.academique-course-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,0.12) !important;
}
.academique-year-card,
.academique-major-card,
.academique-course-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
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
