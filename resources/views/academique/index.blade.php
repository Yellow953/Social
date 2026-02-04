@extends('layouts.dashboard')

@section('title', 'Académique | ESIB SOCIAL')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Académique</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2 class="fw-bold mb-1" style="color: #c2410c;"><i class="fas fa-graduation-cap me-2" style="color: #ec682a;"></i>Académique</h2>
        <p class="text-muted mb-0">Choisissez une année, puis un cours, puis ouvrez un matériel pour le consulter avec filigrane.</p>
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

    <!-- 1. Years: cards across full width -->
    <section id="section-years" class="mb-5">
        <h5 class="fw-bold mb-3" style="color: #c2410c;"><i class="fas fa-calendar-alt me-2" style="color: #ec682a;"></i>1. Choisir une année</h5>
        <div id="years-loading" class="text-center py-5 text-muted">
            <div class="spinner-border me-2" role="status"></div> Chargement des années...
        </div>
        <div id="years-cards" class="row g-3 g-md-4 d-none"></div>
    </section>

    <!-- 2. Courses: cards across full width -->
    <section id="section-courses" class="mb-5 d-none">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
            <h5 class="fw-bold mb-0" style="color: #c2410c;"><i class="fas fa-book-open me-2" style="color: #ec682a;"></i>2. Cours pour <span id="courses-year-label"></span></h5>
            <a href="#" id="back-from-courses" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i> Changer d'année</a>
        </div>
        <div id="courses-loading" class="text-center py-5 text-muted d-none">
            <div class="spinner-border me-2" role="status"></div> Chargement des cours...
        </div>
        <div id="courses-cards" class="row g-3 g-md-4"></div>
        <p id="courses-empty" class="text-muted text-center py-4 d-none">Aucun cours pour cette année.</p>
    </section>

    <!-- 3. Materials: list -->
    <section id="section-materials" class="mb-5 d-none">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
            <h5 class="fw-bold mb-0" style="color: #c2410c;"><i class="fas fa-file-alt me-2" style="color: #ec682a;"></i>3. Matériel pour <span id="materials-course-label"></span></h5>
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

    const sectionYears = document.getElementById('section-years');
    const yearsLoading = document.getElementById('years-loading');
    const yearsCards = document.getElementById('years-cards');
    const sectionCourses = document.getElementById('section-courses');
    const coursesYearLabel = document.getElementById('courses-year-label');
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

    backFromCourses.addEventListener('click', function(e) {
        e.preventDefault();
        selectedYear = null;
        selectedCourseId = null;
        sectionCourses.classList.add('d-none');
        sectionMaterials.classList.add('d-none');
        sectionYears.classList.remove('d-none');
        coursesCards.innerHTML = '';
    });

    backFromMaterials.addEventListener('click', function(e) {
        e.preventDefault();
        selectedCourseId = null;
        sectionMaterials.classList.add('d-none');
        sectionCourses.classList.remove('d-none');
        materialsList.innerHTML = '';
    });

    // Load years on page load
    fetch(yearsUrl, { headers: csrfHeaders(), credentials: 'same-origin' })
        .then(r => r.json())
        .then(data => {
            yearsLoading.classList.add('d-none');
            yearsCards.classList.remove('d-none');
            yearsCards.innerHTML = '';
            (data.years || []).forEach(year => {
                const col = document.createElement('div');
                col.className = 'col-6 col-sm-4 col-md col-xl';
                const card = document.createElement('a');
                card.href = '#';
                card.className = 'card border-0 shadow-sm h-100 text-decoration-none academique-year-card';
                card.style.borderLeft = '4px solid #ec682a';
                card.dataset.year = year;
                card.addEventListener('click', function(e) {
                    e.preventDefault();
                    selectedYear = year;
                    document.querySelectorAll('.academique-year-card').forEach(el => el.classList.remove('border-primary'));
                    this.classList.add('border-primary');
                    sectionYears.classList.add('d-none');
                    sectionCourses.classList.remove('d-none');
                    sectionMaterials.classList.add('d-none');
                    coursesYearLabel.textContent = year;
                    loadCourses(year);
                });
                card.innerHTML = '<div class="card-body text-center py-4"><i class="fas fa-calendar-alt fa-2x mb-2" style="color: #ec682a;"></i><h6 class="fw-bold mb-0 text-dark">' + escapeHtml(year) + '</h6></div>';
                col.appendChild(card);
                yearsCards.appendChild(col);
            });
        })
        .catch(() => {
            yearsLoading.innerHTML = '<span class="text-danger">Erreur de chargement</span>';
        });

    function loadCourses(year) {
        coursesLoading.classList.remove('d-none');
        coursesEmpty.classList.add('d-none');
        coursesCards.innerHTML = '';
        selectedCourseId = null;

        fetch(coursesUrl + '?year=' + encodeURIComponent(year), { headers: csrfHeaders(), credentials: 'same-origin' })
            .then(r => r.json())
            .then(data => {
                coursesLoading.classList.add('d-none');
                if (!data.courses || data.courses.length === 0) {
                    coursesEmpty.classList.remove('d-none');
                    return;
                }
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
                coursesEmpty.textContent = 'Erreur de chargement';
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
.academique-year-card:hover,
.academique-course-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1) !important;
}
.academique-year-card,
.academique-course-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
</style>
@endpush
@endsection
