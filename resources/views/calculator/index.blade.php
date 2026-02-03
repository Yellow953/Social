@extends('layouts.dashboard')

@section('title', 'Grade Calculator | ESIB SOCIAL')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Calculator</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3 mb-4">
                <div>
                    <h2 class="fw-bold mb-1" style="color: #c2410c;">University Grade Calculator</h2>
                    <p class="text-muted small mb-0">Partiel, TP, TC &amp; final — weighted average</p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="text-muted small">Scale</span>
                    <div class="btn-group btn-group-sm" role="group">
                        <input type="radio" class="btn-check" name="scale" id="scale20" checked>
                        <label class="btn btn-scale-toggle" for="scale20">/ 20</label>
                        <input type="radio" class="btn-check" name="scale" id="scale100">
                        <label class="btn btn-scale-toggle" for="scale100">/ 100</label>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- Input panel -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-lg h-100 calculator-card" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                        <div class="card-header bg-transparent border-0 pb-0 pt-4 px-4">
                            <h5 class="mb-0 fw-bold" style="color: #c2410c;">
                                <i class="fas fa-edit me-2" style="color: #ec682a;"></i>Input Scores
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <form id="gradeCalculatorForm">
                                <div class="table-responsive">
                                    <table class="table table-borderless align-middle mb-0">
                                        <thead>
                                            <tr class="border-bottom" style="border-color: #e5e7eb !important;">
                                                <th class="text-muted fw-semibold small text-uppercase pb-3" style="letter-spacing: 0.5px;">Exam</th>
                                                <th class="text-muted fw-semibold small text-uppercase pb-3 text-end" style="letter-spacing: 0.5px;">Score</th>
                                                <th class="text-muted fw-semibold small text-uppercase pb-3 text-end" style="letter-spacing: 0.5px;">Weight %</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="exam-row">
                                                <td class="py-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="exam-icon me-2" style="width: 32px; height: 32px; background: linear-gradient(135deg, #ec682a 0%, #c2410c 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                                            <i class="fas fa-file-alt text-white small"></i>
                                                        </div>
                                                        <span class="fw-semibold" style="color: #c2410c;">Partiel</span>
                                                    </div>
                                                </td>
                                                <td class="py-3 text-end">
                                                    <div class="input-group input-group-sm ms-auto" style="max-width: 110px;">
                                                        <input type="number" class="form-control border" id="midtermScore" min="0" max="20" step="0.01" placeholder="0" required style="border-radius: 6px 0 0 6px !important;">
                                                        <span class="input-group-text border-start-0 small" id="midtermMax" style="background: #f8fafc; border-radius: 0 6px 6px 0 !important;">/20</span>
                                                    </div>
                                                </td>
                                                <td class="py-3 text-end">
                                                    <div class="input-group input-group-sm ms-auto" style="max-width: 90px;">
                                                        <input type="number" class="form-control border" id="midtermPercent" min="0" max="100" step="0.1" value="25" required style="border-radius: 6px 0 0 6px !important;">
                                                        <span class="input-group-text border-start-0 small" style="background: #f8fafc; border-radius: 0 6px 6px 0 !important;">%</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="exam-row">
                                                <td class="py-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="exam-icon me-2" style="width: 32px; height: 32px; background: linear-gradient(135deg, #ec682a 0%, #c2410c 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                                            <i class="fas fa-flask text-white small"></i>
                                                        </div>
                                                        <span class="fw-semibold" style="color: #c2410c;">TP</span>
                                                    </div>
                                                </td>
                                                <td class="py-3 text-end">
                                                    <div class="input-group input-group-sm ms-auto" style="max-width: 110px;">
                                                        <input type="number" class="form-control border" id="tpScore" min="0" max="20" step="0.01" placeholder="0" required style="border-radius: 6px 0 0 6px !important;">
                                                        <span class="input-group-text border-start-0 small" id="tpMax" style="background: #f8fafc; border-radius: 0 6px 6px 0 !important;">/20</span>
                                                    </div>
                                                </td>
                                                <td class="py-3 text-end">
                                                    <div class="input-group input-group-sm ms-auto" style="max-width: 90px;">
                                                        <input type="number" class="form-control border" id="tpPercent" min="0" max="100" step="0.1" value="15" required style="border-radius: 6px 0 0 6px !important;">
                                                        <span class="input-group-text border-start-0 small" style="background: #f8fafc; border-radius: 0 6px 6px 0 !important;">%</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="exam-row">
                                                <td class="py-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="exam-icon me-2" style="width: 32px; height: 32px; background: linear-gradient(135deg, #ec682a 0%, #c2410c 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                                            <i class="fas fa-vial text-white small"></i>
                                                        </div>
                                                        <span class="fw-semibold" style="color: #c2410c;">TC</span>
                                                    </div>
                                                </td>
                                                <td class="py-3 text-end">
                                                    <div class="input-group input-group-sm ms-auto" style="max-width: 110px;">
                                                        <input type="number" class="form-control border" id="tcScore" min="0" max="20" step="0.01" placeholder="0" required style="border-radius: 6px 0 0 6px !important;">
                                                        <span class="input-group-text border-start-0 small" id="tcMax" style="background: #f8fafc; border-radius: 0 6px 6px 0 !important;">/20</span>
                                                    </div>
                                                </td>
                                                <td class="py-3 text-end">
                                                    <div class="input-group input-group-sm ms-auto" style="max-width: 90px;">
                                                        <input type="number" class="form-control border" id="tcPercent" min="0" max="100" step="0.1" value="10" required style="border-radius: 6px 0 0 6px !important;">
                                                        <span class="input-group-text border-start-0 small" style="background: #f8fafc; border-radius: 0 6px 6px 0 !important;">%</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="exam-row">
                                                <td class="py-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="exam-icon me-2" style="width: 32px; height: 32px; background: linear-gradient(135deg, #ec682a 0%, #c2410c 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                                            <i class="fas fa-graduation-cap text-white small"></i>
                                                        </div>
                                                        <span class="fw-semibold" style="color: #c2410c;">Final</span>
                                                    </div>
                                                </td>
                                                <td class="py-3 text-end text-muted small">
                                                    <span id="finalScoreLabel">(calculated)</span>
                                                </td>
                                                <td class="py-3 text-end">
                                                    <div class="input-group input-group-sm ms-auto" style="max-width: 90px;">
                                                        <input type="number" class="form-control border" id="finalPercent" min="0" max="100" step="0.1" value="50" required style="border-radius: 6px 0 0 6px !important;">
                                                        <span class="input-group-text border-start-0 small" style="background: #f8fafc; border-radius: 0 6px 6px 0 !important;">%</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-3 pt-3" style="border-top: 2px solid #e5e7eb;">
                                    <div class="d-flex align-items-center gap-2 mb-3">
                                        <label class="text-muted small mb-0 fw-semibold">Desired overall grade (0–100%)</label>
                                        <div class="input-group input-group-sm" style="max-width: 100px;">
                                            <input type="number" class="form-control border" id="desiredGrade" min="0" max="100" step="0.1" value="50" style="border-radius: 6px;">
                                            <span class="input-group-text border-start-0 small" style="background: #f8fafc; border-radius: 0 6px 6px 0 !important;">%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mt-2 pt-3" style="border-top: 2px solid #e5e7eb;">
                                    <div>
                                        <small class="text-muted d-block">Weights total</small>
                                        <strong id="totalPercent" style="color: #c2410c; font-size: 1.1rem;">100</strong><small class="text-muted">%</small>
                                    </div>
                                    <span id="percentWarning" class="text-danger small d-none">
                                        <i class="fas fa-exclamation-triangle me-1"></i>Must equal 100%
                                    </span>
                                    <button type="button" class="btn px-4 py-2 fw-semibold" id="btnCalculate" onclick="calculateGrade()" style="background: linear-gradient(135deg, #ec682a 0%, #c2410c 100%); color: white; border-radius: 8px; border: none;">
                                        <i class="fas fa-calculator me-2"></i>Calculate
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Result panel -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-lg h-100 result-card" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                        <div class="card-header bg-transparent border-0 pb-0 pt-4 px-4">
                            <h5 class="mb-0 fw-bold" style="color: #c2410c;">
                                <i class="fas fa-chart-line me-2" style="color: #ec682a;"></i>Result
                            </h5>
                        </div>
                        <div class="card-body p-4 d-flex flex-column justify-content-center min-vh-md-0">
                            <div id="resultPlaceholder" class="text-center text-muted py-5">
                                <div class="mb-3 opacity-50">
                                    <div style="width: 80px; height: 80px; margin: 0 auto; background: linear-gradient(135deg, #e5e7eb 0%, #d1d5db 100%); border-radius: 20px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-calculator fa-2x text-muted"></i>
                                    </div>
                                </div>
                                <p class="mb-0 small fw-medium">Enter Partiel, TP &amp; TC scores, set desired grade,<br>then click Calculate.</p>
                            </div>
                            <div id="resultSection" class="d-none">
                                <div class="text-center mb-4 pb-3" style="border-bottom: 2px solid #e5e7eb;">
                                    <p class="text-muted small mb-2 fw-semibold text-uppercase" style="letter-spacing: 1px;">Required final exam score</p>
                                    <div class="d-flex align-items-baseline justify-content-center gap-2 flex-wrap">
                                        <span class="display-3 fw-bold" id="requiredFinal" style="color: #c2410c; line-height: 1;">0.00</span>
                                        <span class="fs-3 text-muted fw-normal" id="gradeOutOf">/ 20</span>
                                    </div>
                                    <p class="text-muted small mt-2 mb-0">To get <strong id="desiredGradeDisplay">50</strong>% overall</p>
                                </div>
                                <div class="pt-3">
                                    <p class="small text-muted mb-3 fw-semibold text-uppercase" style="letter-spacing: 0.5px;">Contributions so far</p>
                                    <div class="breakdown-item mb-2 pb-2" style="border-bottom: 1px solid #f3f4f6;">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="small fw-medium">Partiel</span>
                                            <span class="fw-bold" id="midtermContribution" style="color: #ec682a;">0</span>
                                        </div>
                                    </div>
                                    <div class="breakdown-item mb-2 pb-2" style="border-bottom: 1px solid #f3f4f6;">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="small fw-medium">TP</span>
                                            <span class="fw-bold" id="tpContribution" style="color: #ec682a;">0</span>
                                        </div>
                                    </div>
                                    <div class="breakdown-item mb-2 pb-2" style="border-bottom: 1px solid #f3f4f6;">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="small fw-medium">TC</span>
                                            <span class="fw-bold" id="tcContribution" style="color: #ec682a;">0</span>
                                        </div>
                                    </div>
                                    <div class="breakdown-item mb-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="small fw-medium">Final (needed)</span>
                                            <span class="fw-bold" id="finalContribution" style="color: #ec682a;">0</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="alert mb-0 py-2 px-3 small rounded" id="gradeInterpretation" role="alert" style="border-radius: 8px !important;">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <span id="gradeMessage"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Semester GPA Calculator -->
            <div class="mt-5 pt-4 border-top" style="border-color: #e5e7eb !important;">
                <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3 mb-4">
                    <div>
                        <h2 class="fw-bold mb-1" style="color: #c2410c;">Semester GPA Calculator</h2>
                        <p class="text-muted small mb-0">Final grade &amp; GPA for all courses in a semester (weighted by credits)</p>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-muted small">Scale</span>
                        <div class="btn-group btn-group-sm" role="group">
                            <input type="radio" class="btn-check" name="semesterScale" id="semesterScale20" checked>
                            <label class="btn btn-scale-toggle" for="semesterScale20">/ 20</label>
                            <input type="radio" class="btn-check" name="semesterScale" id="semesterScale100">
                            <label class="btn btn-scale-toggle" for="semesterScale100">/ 100</label>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-lg h-100 calculator-card" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                            <div class="card-header bg-transparent border-0 pb-0 pt-4 px-4 d-flex align-items-center justify-content-between">
                                <h5 class="mb-0 fw-bold" style="color: #c2410c;">
                                    <i class="fas fa-book me-2" style="color: #ec682a;"></i>Courses
                                </h5>
                                <button type="button" class="btn btn-sm px-3 py-1 fw-semibold" id="btnAddCourse" onclick="addCourseRow()" style="background: linear-gradient(135deg, #ec682a 0%, #c2410c 100%); color: white; border-radius: 6px; border: none;">
                                    <i class="fas fa-plus me-1"></i>Add course
                                </button>
                            </div>
                            <div class="card-body p-4">
                                <form id="semesterGpaForm">
                                    <div class="table-responsive">
                                        <table class="table table-borderless align-middle mb-0">
                                            <thead>
                                                <tr class="border-bottom" style="border-color: #e5e7eb !important;">
                                                    <th class="text-muted fw-semibold small text-uppercase pb-3" style="letter-spacing: 0.5px;">Course</th>
                                                    <th class="text-muted fw-semibold small text-uppercase pb-3 text-end" style="letter-spacing: 0.5px;">Grade</th>
                                                    <th class="text-muted fw-semibold small text-uppercase pb-3 text-end" style="letter-spacing: 0.5px;">Credits</th>
                                                    <th class="text-muted fw-semibold small text-uppercase pb-3 text-end" style="letter-spacing: 0.5px; width: 48px;"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="semesterCoursesBody">
                                                <!-- Rows added by JS -->
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mt-4 pt-3" style="border-top: 2px solid #e5e7eb;">
                                        <div>
                                            <small class="text-muted d-block">Total credits</small>
                                            <strong id="semesterTotalCredits" style="color: #c2410c; font-size: 1.1rem;">0</strong>
                                        </div>
                                        <button type="button" class="btn px-4 py-2 fw-semibold" id="btnCalculateSemester" onclick="calculateSemesterGpa()" style="background: linear-gradient(135deg, #ec682a 0%, #c2410c 100%); color: white; border-radius: 8px; border: none;">
                                            <i class="fas fa-calculator me-2"></i>Calculate GPA
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-lg h-100 result-card" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                            <div class="card-header bg-transparent border-0 pb-0 pt-4 px-4">
                                <h5 class="mb-0 fw-bold" style="color: #c2410c;">
                                    <i class="fas fa-chart-pie me-2" style="color: #ec682a;"></i>Semester Result
                                </h5>
                            </div>
                            <div class="card-body p-4 d-flex flex-column justify-content-center min-vh-md-0">
                                <div id="semesterResultPlaceholder" class="text-center text-muted py-5">
                                    <div class="mb-3 opacity-50">
                                        <div style="width: 80px; height: 80px; margin: 0 auto; background: linear-gradient(135deg, #e5e7eb 0%, #d1d5db 100%); border-radius: 20px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-graduation-cap fa-2x text-muted"></i>
                                        </div>
                                    </div>
                                    <p class="mb-0 small fw-medium">Add courses (grade + credits),<br>then click Calculate GPA.</p>
                                </div>
                                <div id="semesterResultSection" class="d-none">
                                    <div class="text-center mb-4 pb-3" style="border-bottom: 2px solid #e5e7eb;">
                                        <p class="text-muted small mb-2 fw-semibold text-uppercase" style="letter-spacing: 1px;">Semester Average</p>
                                        <div class="d-flex align-items-baseline justify-content-center gap-2">
                                            <span class="display-3 fw-bold" id="semesterFinalGrade" style="color: #c2410c; line-height: 1;">0.00</span>
                                            <span class="fs-3 text-muted fw-normal" id="semesterGradeOutOf">/ 20</span>
                                        </div>
                                        <div class="d-flex justify-content-center gap-4 mt-3 flex-wrap">
                                            <div>
                                                <span class="text-muted small">Letter Grade</span>
                                                <span class="d-block fw-bold fs-4" id="semesterGpaLetter" style="color: #c2410c;">—</span>
                                            </div>
                                            <div>
                                                <span class="text-muted small">Semester GPA</span>
                                                <span class="d-block fw-bold fs-4" id="semesterGpaNumeric" style="color: #c2410c;">—</span>
                                            </div>
                                            <div>
                                                <span class="text-muted small">Definition</span>
                                                <span class="d-block fw-bold small" id="semesterGpaDefinition" style="color: #c2410c;">—</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pt-3">
                                        <p class="small text-muted mb-3 fw-semibold text-uppercase" style="letter-spacing: 0.5px;">By course</p>
                                        <div id="semesterBreakdownList" class="small">
                                            <!-- Filled by JS -->
                                        </div>
                                    </div>
                                    <div class="alert mb-0 mt-3 py-2 px-3 small rounded" id="semesterInterpretation" role="alert" style="border-radius: 8px !important;">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <span id="semesterMessage"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .min-vh-md-0 { min-height: 0; }
    @media (min-width: 992px) {
        .min-vh-md-0 { min-height: 18rem; }
    }
    #resultCard .card-body { min-height: 16rem; }
    
    /* Enhanced card styling */
    .calculator-card, .result-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .calculator-card:hover, .result-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
    }
    
    .exam-row {
        transition: background-color 0.2s ease;
    }
    
    .exam-row:hover {
        background-color: #f8fafc;
        border-radius: 8px;
    }
    
    .form-control:focus {
        border-color: #ec682a !important;
        box-shadow: 0 0 0 0.2rem rgba(236, 104, 42, 0.25) !important;
    }
    
    .btn-scale-toggle {
        color: #ec682a;
        border-color: #ec682a;
    }
    .btn-scale-toggle:hover {
        color: #fff;
        background-color: #ec682a;
        border-color: #ec682a;
    }
    .btn-check:checked + .btn-scale-toggle {
        color: #fff;
        background-color: #ec682a;
        border-color: #ec682a;
    }
    
    #btnCalculate {
        transition: all 0.2s ease;
    }
    
    #btnCalculate:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(236, 104, 42, 0.35);
    }
    
    .breakdown-item {
        transition: background-color 0.2s ease;
        padding-left: 8px;
        padding-right: 8px;
        margin-left: -8px;
        margin-right: -8px;
        border-radius: 6px;
    }
    
    .breakdown-item:hover {
        background-color: #f8fafc;
    }
</style>

<script>
    let gradeScale = 20;

    document.getElementById('scale20').addEventListener('change', function() {
        if (this.checked) setScale(20);
    });
    document.getElementById('scale100').addEventListener('change', function() {
        if (this.checked) setScale(100);
    });

    function setScale(scale) {
        gradeScale = scale;
        var maxText = '/' + scale;
        document.getElementById('midtermScore').max = scale;
        document.getElementById('tpScore').max = scale;
        document.getElementById('tcScore').max = scale;
        document.getElementById('midtermMax').textContent = maxText;
        document.getElementById('tpMax').textContent = maxText;
        document.getElementById('tcMax').textContent = maxText;
        document.getElementById('resultSection').classList.add('d-none');
        document.getElementById('resultPlaceholder').classList.remove('d-none');
    }

    document.getElementById('midtermPercent').addEventListener('input', updateTotalPercent);
    document.getElementById('finalPercent').addEventListener('input', updateTotalPercent);
    document.getElementById('tpPercent').addEventListener('input', updateTotalPercent);
    document.getElementById('tcPercent').addEventListener('input', updateTotalPercent);

    function updateTotalPercent() {
        var m = parseFloat(document.getElementById('midtermPercent').value) || 0;
        var f = parseFloat(document.getElementById('finalPercent').value) || 0;
        var t = parseFloat(document.getElementById('tpPercent').value) || 0;
        var tc = parseFloat(document.getElementById('tcPercent').value) || 0;
        var total = m + f + t + tc;
        document.getElementById('totalPercent').textContent = total.toFixed(1);
        var w = document.getElementById('percentWarning');
        if (Math.abs(total - 100) > 0.1) w.classList.remove('d-none'); else w.classList.add('d-none');
    }

    function calculateGrade() {
        var midtermScore = parseFloat(document.getElementById('midtermScore').value) || 0;
        var tpScore = parseFloat(document.getElementById('tpScore').value) || 0;
        var tcScore = parseFloat(document.getElementById('tcScore').value) || 0;
        var midtermPercent = parseFloat(document.getElementById('midtermPercent').value) || 0;
        var finalPercent = parseFloat(document.getElementById('finalPercent').value) || 0;
        var tpPercent = parseFloat(document.getElementById('tpPercent').value) || 0;
        var tcPercent = parseFloat(document.getElementById('tcPercent').value) || 0;
        var desiredGrade = parseFloat(document.getElementById('desiredGrade').value);
        if (isNaN(desiredGrade) || desiredGrade < 0 || desiredGrade > 100) desiredGrade = 50;
        document.getElementById('desiredGrade').value = desiredGrade;
        var totalPercent = midtermPercent + finalPercent + tpPercent + tcPercent;

        if (Math.abs(totalPercent - 100) > 0.1) {
            alert('Weights must total 100%. Current: ' + totalPercent.toFixed(1) + '%');
            return;
        }
        if (midtermScore < 0 || midtermScore > gradeScale || tpScore < 0 || tpScore > gradeScale || tcScore < 0 || tcScore > gradeScale) {
            alert('Scores must be between 0 and ' + gradeScale);
            return;
        }
        if (finalPercent <= 0) {
            alert('Final exam weight must be greater than 0% to calculate required final score.');
            return;
        }

        // Contributions from Partiel, TP and TC (in 0–100 scale)
        var midtermContribution = (midtermScore / gradeScale) * midtermPercent;
        var tpContribution = (tpScore / gradeScale) * tpPercent;
        var tcContribution = (tcScore / gradeScale) * tcPercent;
        // Required contribution from final to reach desired overall (0–100)
        var requiredFinalContribution = desiredGrade - midtermContribution - tpContribution - tcContribution;
        // Required final exam score on the chosen scale
        var requiredFinalScore = (requiredFinalContribution / finalPercent) * gradeScale;

        var displayRequired = requiredFinalScore < 0 ? 0 : (requiredFinalScore > gradeScale ? gradeScale : requiredFinalScore);
        document.getElementById('requiredFinal').textContent = displayRequired.toFixed(2);
        document.getElementById('gradeOutOf').textContent = '/ ' + gradeScale;
        document.getElementById('desiredGradeDisplay').textContent = desiredGrade.toFixed(1);
        document.getElementById('midtermContribution').textContent = midtermContribution.toFixed(2) + '%';
        document.getElementById('tpContribution').textContent = tpContribution.toFixed(2) + '%';
        document.getElementById('tcContribution').textContent = tcContribution.toFixed(2) + '%';
        document.getElementById('finalContribution').textContent = requiredFinalContribution.toFixed(2) + '%';

        var message = '', alertClass = '';
        if (requiredFinalScore > gradeScale) {
            message = 'You need more than ' + gradeScale + ' on the final to get ' + desiredGrade + '% overall — not possible. Try a lower desired grade or improve Partiel/TP/TC.';
            alertClass = 'alert-danger';
        } else if (requiredFinalScore < 0) {
            message = 'You already have enough points to reach ' + desiredGrade + '% overall. No minimum final score needed.';
            alertClass = 'alert-success';
        } else if (requiredFinalScore <= gradeScale * 0.5) {
            message = 'You need ' + requiredFinalScore.toFixed(1) + ' on the final to get ' + desiredGrade + '% overall.';
            alertClass = 'alert-info';
        } else {
            message = 'You need ' + requiredFinalScore.toFixed(1) + ' on the final to get ' + desiredGrade + '% overall.';
            alertClass = 'alert-info';
        }

        document.getElementById('gradeInterpretation').className = 'alert ' + alertClass + ' py-2 small';
        document.getElementById('gradeMessage').textContent = message;

        document.getElementById('resultPlaceholder').classList.add('d-none');
        document.getElementById('resultSection').classList.remove('d-none');
    }

    document.getElementById('gradeCalculatorForm').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') { e.preventDefault(); calculateGrade(); }
    });

    // ——— Semester GPA Calculator ———
    let semesterScale = 20;
    let semesterCourseId = 0;

    document.getElementById('semesterScale20').addEventListener('change', function() {
        if (this.checked) setSemesterScale(20);
    });
    document.getElementById('semesterScale100').addEventListener('change', function() {
        if (this.checked) setSemesterScale(100);
    });

    function setSemesterScale(scale) {
        semesterScale = scale;
        document.querySelectorAll('.semester-grade-input').forEach(function(inp) {
            inp.max = scale;
        });
        document.querySelectorAll('.semester-grade-max').forEach(function(el) {
            el.textContent = '/' + scale;
        });
        document.getElementById('semesterResultSection').classList.add('d-none');
        document.getElementById('semesterResultPlaceholder').classList.remove('d-none');
    }

    function addCourseRow() {
        var id = ++semesterCourseId;
        var maxText = '/' + semesterScale;
        var row = document.createElement('tr');
        row.className = 'semester-course-row';
        row.dataset.courseId = id;
        row.innerHTML =
            '<td class="py-2 align-middle">' +
            '<input type="text" class="form-control form-control-sm border semester-course-name" placeholder="Course name" style="max-width: 160px; border-radius: 6px;">' +
            '</td>' +
            '<td class="py-2 text-end align-middle">' +
            '<div class="input-group input-group-sm ms-auto d-inline-flex" style="max-width: 110px;">' +
            '<input type="number" class="form-control border semester-grade-input" min="0" max="' + semesterScale + '" step="0.01" placeholder="0" style="border-radius: 6px 0 0 6px !important;">' +
            '<span class="input-group-text border-start-0 small semester-grade-max" style="background: #f8fafc; border-radius: 0 6px 6px 0 !important;">' + maxText + '</span>' +
            '</div>' +
            '</td>' +
            '<td class="py-2 text-end align-middle">' +
            '<div class="input-group input-group-sm ms-auto d-inline-flex" style="max-width: 80px;">' +
            '<input type="number" class="form-control border semester-credits-input" min="0.5" max="99" step="0.5" value="3" required style="border-radius: 6px;">' +
            '</div>' +
            '</td>' +
            '<td class="py-2 text-end align-middle" style="width: 48px;">' +
            '<button type="button" class="btn btn-sm btn-outline-danger p-1 semester-remove-btn" onclick="removeCourseRow(' + id + ')" title="Remove course" style="border-radius: 6px;">' +
            '<i class="fas fa-times small"></i>' +
            '</button>' +
            '</td>';
        document.getElementById('semesterCoursesBody').appendChild(row);
        updateSemesterTotalCredits();
    }

    function removeCourseRow(courseId) {
        var row = document.querySelector('.semester-course-row[data-course-id="' + courseId + '"]');
        if (row) {
            row.remove();
            updateSemesterTotalCredits();
        }
        document.getElementById('semesterResultSection').classList.add('d-none');
        document.getElementById('semesterResultPlaceholder').classList.remove('d-none');
    }

    function updateSemesterTotalCredits() {
        var total = 0;
        document.querySelectorAll('.semester-credits-input').forEach(function(inp) {
            total += parseFloat(inp.value) || 0;
        });
        document.getElementById('semesterTotalCredits').textContent = total.toFixed(1);
    }

    document.getElementById('semesterCoursesBody').addEventListener('input', function() {
        updateSemesterTotalCredits();
    });

    function calculateSemesterGpa() {
        var rows = document.querySelectorAll('.semester-course-row');
        if (rows.length === 0) {
            alert('Add at least one course.');
            return;
        }
        var totalWeighted = 0;
        var totalCredits = 0;
        var breakdown = [];
        rows.forEach(function(row) {
            var gradeInp = row.querySelector('.semester-grade-input');
            var creditsInp = row.querySelector('.semester-credits-input');
            var nameInp = row.querySelector('.semester-course-name');
            var grade = parseFloat(gradeInp.value);
            var credits = parseFloat(creditsInp.value) || 0;
            if (isNaN(grade) || grade < 0 || grade > semesterScale || credits <= 0) return;
            totalWeighted += grade * credits;
            totalCredits += credits;
            var name = (nameInp && nameInp.value.trim()) ? nameInp.value.trim() : ('Course ' + row.dataset.courseId);
            breakdown.push({ name: name, grade: grade, credits: credits });
        });
        if (totalCredits <= 0) {
            alert('Enter at least one valid grade and credits.');
            return;
        }
        var avgRaw = totalWeighted / totalCredits;
        var avgOutOf20 = semesterScale === 20 ? avgRaw : (avgRaw / 100) * 20;
        var usj = getUsjGrade(avgOutOf20);

        document.getElementById('semesterFinalGrade').textContent = avgRaw.toFixed(2);
        document.getElementById('semesterGradeOutOf').textContent = '/ ' + semesterScale;
        document.getElementById('semesterGpaLetter').textContent = usj.letter;
        document.getElementById('semesterGpaNumeric').textContent = usj.gpa !== null ? usj.gpa.toFixed(1) : '—';
        document.getElementById('semesterGpaDefinition').textContent = usj.definition;

        var listHtml = '';
        breakdown.forEach(function(b) {
            listHtml += '<div class="d-flex justify-content-between align-items-center mb-2 pb-2" style="border-bottom: 1px solid #f3f4f6;">' +
                '<span class="fw-medium text-truncate me-2" style="max-width: 60%;">' + escapeHtml(b.name) + '</span>' +
                '<span class="fw-bold" style="color: #ec682a;">' + b.grade.toFixed(2) + ' × ' + b.credits + '</span>' +
                '</div>';
        });
        document.getElementById('semesterBreakdownList').innerHTML = listHtml || '<p class="text-muted small mb-0">—</p>';

        var message = '', alertClass = '';
        if (avgOutOf20 >= 18) { message = 'Excellent semester (A+).'; alertClass = 'alert-success'; }
        else if (avgOutOf20 >= 16) { message = 'Excellent to Very Good (A to A-).'; alertClass = 'alert-success'; }
        else if (avgOutOf20 >= 14) { message = 'Good semester (B+ to B-).'; alertClass = 'alert-info'; }
        else if (avgOutOf20 >= 12) { message = 'Fair (C+ to C-).'; alertClass = 'alert-info'; }
        else if (avgOutOf20 >= 10) { message = 'Passing (D+ to D-).'; alertClass = 'alert-warning'; }
        else if (avgOutOf20 >= 8) { message = 'Jury range — average may be adjusted.'; alertClass = 'alert-warning'; }
        else { message = 'Fail (F).'; alertClass = 'alert-danger'; }
        document.getElementById('semesterInterpretation').className = 'alert ' + alertClass + ' py-2 small mt-3';
        document.getElementById('semesterMessage').textContent = message;

        document.getElementById('semesterResultPlaceholder').classList.add('d-none');
        document.getElementById('semesterResultSection').classList.remove('d-none');
    }

    function escapeHtml(text) {
        var div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    document.getElementById('semesterGpaForm').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') { e.preventDefault(); calculateSemesterGpa(); }
    });

    addCourseRow();
</script>
@endsection
