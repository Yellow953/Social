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
                    <p class="text-muted small mb-0">Midterm, final &amp; TP — weighted average</p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="text-muted small">Scale</span>
                    <div class="btn-group btn-group-sm" role="group">
                        <input type="radio" class="btn-check" name="scale" id="scale20" checked>
                        <label class="btn btn-outline-primary" for="scale20">/ 20</label>
                        <input type="radio" class="btn-check" name="scale" id="scale100">
                        <label class="btn btn-outline-primary" for="scale100">/ 100</label>
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
                                                        <span class="fw-semibold" style="color: #c2410c;">Midterm</span>
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
                                                        <input type="number" class="form-control border" id="midtermPercent" min="0" max="100" step="0.1" value="30" required style="border-radius: 6px 0 0 6px !important;">
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
                                                        <input type="number" class="form-control border" id="tpPercent" min="0" max="100" step="0.1" value="20" required style="border-radius: 6px 0 0 6px !important;">
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
                                                <td class="py-3 text-end">
                                                    <div class="input-group input-group-sm ms-auto" style="max-width: 110px;">
                                                        <input type="number" class="form-control border" id="finalScore" min="0" max="20" step="0.01" placeholder="0" required style="border-radius: 6px 0 0 6px !important;">
                                                        <span class="input-group-text border-start-0 small" id="finalMax" style="background: #f8fafc; border-radius: 0 6px 6px 0 !important;">/20</span>
                                                    </div>
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
                                <div class="d-flex align-items-center justify-content-between mt-4 pt-3" style="border-top: 2px solid #e5e7eb;">
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
                                <p class="mb-0 small fw-medium">Enter scores and weights,<br>then click Calculate.</p>
                            </div>
                            <div id="resultSection" class="d-none">
                                <div class="text-center mb-4 pb-3" style="border-bottom: 2px solid #e5e7eb;">
                                    <p class="text-muted small mb-2 fw-semibold text-uppercase" style="letter-spacing: 1px;">Final Grade</p>
                                    <div class="d-flex align-items-baseline justify-content-center gap-2">
                                        <span class="display-3 fw-bold" id="finalGrade" style="color: #c2410c; line-height: 1;">0.00</span>
                                        <span class="fs-3 text-muted fw-normal" id="gradeOutOf">/ 20</span>
                                    </div>
                                    <div class="d-flex justify-content-center gap-4 mt-3 flex-wrap">
                                        <div>
                                            <span class="text-muted small">USJ Rank (Letter)</span>
                                            <span class="d-block fw-bold fs-4" id="gpaLetter" style="color: #c2410c;">—</span>
                                        </div>
                                        <div>
                                            <span class="text-muted small">Rank Value / GPA</span>
                                            <span class="d-block fw-bold fs-4" id="gpaNumeric" style="color: #c2410c;">—</span>
                                        </div>
                                        <div>
                                            <span class="text-muted small">Definition</span>
                                            <span class="d-block fw-bold small" id="gpaDefinition" style="color: #c2410c;">—</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-3">
                                    <p class="small text-muted mb-3 fw-semibold text-uppercase" style="letter-spacing: 0.5px;">Breakdown</p>
                                    <div class="breakdown-item mb-2 pb-2" style="border-bottom: 1px solid #f3f4f6;">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="small fw-medium">Midterm</span>
                                            <span class="fw-bold" id="midtermContribution" style="color: #ec682a;">0</span>
                                        </div>
                                    </div>
                                    <div class="breakdown-item mb-2 pb-2" style="border-bottom: 1px solid #f3f4f6;">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="small fw-medium">TP</span>
                                            <span class="fw-bold" id="tpContribution" style="color: #ec682a;">0</span>
                                        </div>
                                    </div>
                                    <div class="breakdown-item mb-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="small fw-medium">Final</span>
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
        box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.15) !important;
    }
    
    #btnCalculate {
        transition: all 0.2s ease;
    }
    
    #btnCalculate:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
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
        document.getElementById('finalScore').max = scale;
        document.getElementById('tpScore').max = scale;
        document.getElementById('midtermMax').textContent = maxText;
        document.getElementById('finalMax').textContent = maxText;
        document.getElementById('tpMax').textContent = maxText;
        document.getElementById('resultSection').classList.add('d-none');
        document.getElementById('resultPlaceholder').classList.remove('d-none');
    }

    document.getElementById('midtermPercent').addEventListener('input', updateTotalPercent);
    document.getElementById('finalPercent').addEventListener('input', updateTotalPercent);
    document.getElementById('tpPercent').addEventListener('input', updateTotalPercent);

    function updateTotalPercent() {
        var m = parseFloat(document.getElementById('midtermPercent').value) || 0;
        var f = parseFloat(document.getElementById('finalPercent').value) || 0;
        var t = parseFloat(document.getElementById('tpPercent').value) || 0;
        var total = m + f + t;
        document.getElementById('totalPercent').textContent = total.toFixed(1);
        var w = document.getElementById('percentWarning');
        if (Math.abs(total - 100) > 0.1) w.classList.remove('d-none'); else w.classList.add('d-none');
    }

    // USJ grading system (Table 1 - grade/20 scale)
    function getUsjGrade(gradeOutOf20) {
        var g = gradeOutOf20;
        if (g >= 18) return { letter: 'A+', gpa: 4.0, definition: 'Excellent' };
        if (g >= 17) return { letter: 'A', gpa: 4.0, definition: 'Excellent' };
        if (g >= 16) return { letter: 'A-', gpa: 3.7, definition: 'Very Good' };
        if (g >= 15.34) return { letter: 'B+', gpa: 3.3, definition: 'Good' };
        if (g >= 14.67) return { letter: 'B', gpa: 3.1, definition: 'Good' };
        if (g >= 14) return { letter: 'B-', gpa: 3.0, definition: 'Good' };
        if (g >= 13.34) return { letter: 'C+', gpa: 2.7, definition: 'Fair' };
        if (g >= 12.67) return { letter: 'C', gpa: 2.3, definition: 'Fair' };
        if (g >= 12) return { letter: 'C-', gpa: 2.1, definition: 'Fair' };
        if (g >= 11.34) return { letter: 'D+', gpa: 2.0, definition: 'Passing' };
        if (g >= 10.67) return { letter: 'D', gpa: 1.7, definition: 'Passing' };
        if (g >= 10) return { letter: 'D-', gpa: 1.3, definition: 'Passing' };
        if (g >= 8) return { letter: '(jury)*', gpa: null, definition: '(jury)' };
        return { letter: 'F', gpa: null, definition: 'Fail' };
    }

    function calculateGrade() {
        var midtermScore = parseFloat(document.getElementById('midtermScore').value) || 0;
        var finalScore = parseFloat(document.getElementById('finalScore').value) || 0;
        var tpScore = parseFloat(document.getElementById('tpScore').value) || 0;
        var midtermPercent = parseFloat(document.getElementById('midtermPercent').value) || 0;
        var finalPercent = parseFloat(document.getElementById('finalPercent').value) || 0;
        var tpPercent = parseFloat(document.getElementById('tpPercent').value) || 0;
        var totalPercent = midtermPercent + finalPercent + tpPercent;

        if (Math.abs(totalPercent - 100) > 0.1) {
            alert('Weights must total 100%. Current: ' + totalPercent.toFixed(1) + '%');
            return;
        }
        if (midtermScore < 0 || midtermScore > gradeScale || finalScore < 0 || finalScore > gradeScale || tpScore < 0 || tpScore > gradeScale) {
            alert('Scores must be between 0 and ' + gradeScale);
            return;
        }

        var midtermContribution = (midtermScore / gradeScale) * midtermPercent;
        var finalContribution = (finalScore / gradeScale) * finalPercent;
        var tpContribution = (tpScore / gradeScale) * tpPercent;
        var finalGrade = midtermContribution + finalContribution + tpContribution;
        var finalGradeOutOfScale = (finalGrade / 100) * gradeScale;
        var finalGradeOutOf20 = (finalGrade / 100) * 20;

        document.getElementById('finalGrade').textContent = finalGradeOutOfScale.toFixed(2);
        document.getElementById('gradeOutOf').textContent = '/ ' + gradeScale;
        document.getElementById('midtermContribution').textContent = midtermContribution.toFixed(2);
        document.getElementById('finalContribution').textContent = finalContribution.toFixed(2);
        document.getElementById('tpContribution').textContent = tpContribution.toFixed(2);

        var usj = getUsjGrade(finalGradeOutOf20);
        document.getElementById('gpaLetter').textContent = usj.letter;
        document.getElementById('gpaNumeric').textContent = usj.gpa !== null ? usj.gpa.toFixed(1) : '—';
        document.getElementById('gpaDefinition').textContent = usj.definition;

        var message = '', alertClass = '';
        if (finalGradeOutOf20 >= 18) { message = 'Excellent (A+).'; alertClass = 'alert-success'; }
        else if (finalGradeOutOf20 >= 16) { message = 'Excellent to Very Good (A to A-).'; alertClass = 'alert-success'; }
        else if (finalGradeOutOf20 >= 14) { message = 'Good (B+ to B-).'; alertClass = 'alert-info'; }
        else if (finalGradeOutOf20 >= 12) { message = 'Fair (C+ to C-).'; alertClass = 'alert-info'; }
        else if (finalGradeOutOf20 >= 10) { message = 'Passing (D+ to D-).'; alertClass = 'alert-warning'; }
        else if (finalGradeOutOf20 >= 8) { message = 'Jury range — grade may be adjusted by the jury (ref. Table 2).'; alertClass = 'alert-warning'; }
        else { message = 'Fail (F).'; alertClass = 'alert-danger'; }

        document.getElementById('gradeInterpretation').className = 'alert ' + alertClass + ' py-2 small';
        document.getElementById('gradeMessage').textContent = message;

        document.getElementById('resultPlaceholder').classList.add('d-none');
        document.getElementById('resultSection').classList.remove('d-none');
    }

    document.getElementById('gradeCalculatorForm').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') { e.preventDefault(); calculateGrade(); }
    });
</script>
@endsection
