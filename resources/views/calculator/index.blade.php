@extends('layouts.dashboard')

@section('title', 'Grade Calculator - Social Plus')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Calculator</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Page Header -->
            <div class="text-center mb-4">
                <h2 class="fw-bold mb-1" style="color: #1e3a8a;"><i class="fas fa-calculator me-2" style="color: #3b82f6;"></i>University Grade Calculator</h2>
                <p class="text-muted mb-0">Calculate your final grade based on exam scores and percentages</p>
            </div>

            <!-- Calculator Card -->
            <div class="card border-0 shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #3b82f6 !important;">
                <div class="card-body p-4">
                    <form id="gradeCalculatorForm">
                        <!-- Grade Scale Toggle -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="fw-bold mb-0" style="color: #1e3a8a;">
                                    <i class="fas fa-clipboard-list me-2" style="color: #3b82f6;"></i>Exam Scores
                                </h5>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="fw-semibold" style="color: #5c5c5c;">/20</span>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="gradeScaleToggle" onchange="toggleGradeScale()" style="width: 3rem; height: 1.5rem; cursor: pointer;">
                                    </div>
                                    <span class="fw-semibold" style="color: #5c5c5c;">/100</span>
                                </div>
                            </div>
                        </div>

                        <!-- Exam Scores Section -->
                        <div class="mb-4">
                            <div class="row g-3">
                                <!-- Midterm Exam -->
                                <div class="col-md-4">
                                    <label for="midtermScore" class="form-label fw-semibold">
                                        <i class="fas fa-file-alt me-2" style="color: #3b82f6;"></i>Midterm Exam Score
                                    </label>
                                    <div class="input-group">
                                        <input type="number" 
                                               class="form-control form-control-lg" 
                                               id="midtermScore" 
                                               name="midtermScore"
                                               min="0" 
                                               max="20" 
                                               step="0.01"
                                               placeholder="Enter score"
                                               required>
                                        <span class="input-group-text bg-light" id="midtermMax">/ 20</span>
                                    </div>
                                </div>

                                <!-- Final Exam -->
                                <div class="col-md-4">
                                    <label for="finalScore" class="form-label fw-semibold">
                                        <i class="fas fa-graduation-cap me-2" style="color: #3b82f6;"></i>Final Exam Score
                                    </label>
                                    <div class="input-group">
                                        <input type="number" 
                                               class="form-control form-control-lg" 
                                               id="finalScore" 
                                               name="finalScore"
                                               min="0" 
                                               max="20" 
                                               step="0.01"
                                               placeholder="Enter score"
                                               required>
                                        <span class="input-group-text bg-light" id="finalMax">/ 20</span>
                                    </div>
                                </div>

                                <!-- TP Exam -->
                                <div class="col-md-4">
                                    <label for="tpScore" class="form-label fw-semibold">
                                        <i class="fas fa-flask me-2" style="color: #3b82f6;"></i>TP (Practical Work) Score
                                    </label>
                                    <div class="input-group">
                                        <input type="number" 
                                               class="form-control form-control-lg" 
                                               id="tpScore" 
                                               name="tpScore"
                                               min="0" 
                                               max="20" 
                                               step="0.01"
                                               placeholder="Enter score"
                                               required>
                                        <span class="input-group-text bg-light" id="tpMax">/ 20</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Percentages Section -->
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3" style="color: #1e3a8a;">
                                <i class="fas fa-percentage me-2" style="color: #3b82f6;"></i>Weight Percentages
                            </h5>
                            <div class="alert alert-info mb-3">
                                <i class="fas fa-info-circle me-2"></i>
                                <small>Adjust the percentages below. They should total 100%.</small>
                            </div>
                            
                            <div class="row g-3">
                                <!-- Midterm Percentage -->
                                <div class="col-md-4">
                                    <label for="midtermPercent" class="form-label fw-semibold">Midterm %</label>
                                    <div class="input-group">
                                        <input type="number" 
                                               class="form-control form-control-lg" 
                                               id="midtermPercent" 
                                               name="midtermPercent"
                                               min="0" 
                                               max="100" 
                                               step="0.1"
                                               value="30"
                                               required>
                                        <span class="input-group-text bg-light">%</span>
                                    </div>
                                </div>

                                <!-- Final Percentage -->
                                <div class="col-md-4">
                                    <label for="finalPercent" class="form-label fw-semibold">Final %</label>
                                    <div class="input-group">
                                        <input type="number" 
                                               class="form-control form-control-lg" 
                                               id="finalPercent" 
                                               name="finalPercent"
                                               min="0" 
                                               max="100" 
                                               step="0.1"
                                               value="50"
                                               required>
                                        <span class="input-group-text bg-light">%</span>
                                    </div>
                                </div>

                                <!-- TP Percentage -->
                                <div class="col-md-4">
                                    <label for="tpPercent" class="form-label fw-semibold">TP %</label>
                                    <div class="input-group">
                                        <input type="number" 
                                               class="form-control form-control-lg" 
                                               id="tpPercent" 
                                               name="tpPercent"
                                               min="0" 
                                               max="100" 
                                               step="0.1"
                                               value="20"
                                               required>
                                        <span class="input-group-text bg-light">%</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Percentage Display -->
                            <div class="mt-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-semibold">Total:</span>
                                    <span id="totalPercent" class="fw-bold" style="color: #1e3a8a; font-size: 1.2rem;">100%</span>
                                </div>
                                <div class="progress mt-2" style="height: 8px;">
                                    <div id="percentProgress" 
                                         class="progress-bar" 
                                         role="progressbar" 
                                         style="width: 100%; background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);"
                                         aria-valuenow="100" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100"></div>
                                </div>
                                <small id="percentWarning" class="text-danger d-none">
                                    <i class="fas fa-exclamation-triangle me-1"></i>Percentages must total 100%
                                </small>
                            </div>
                        </div>

                        <!-- Calculate Button -->
                        <div class="text-center mb-4">
                            <button type="button" 
                                    class="btn btn-lg text-white fw-bold px-5 py-3"
                                    style="background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);"
                                    onclick="calculateGrade()">
                                <i class="fas fa-calculator me-2"></i>Calculate Final Grade
                            </button>
                        </div>

                        <!-- Result Display -->
                        <div id="resultSection" class="d-none">
                            <div class="border-top pt-4 mt-4">
                                <h5 class="fw-bold mb-3" style="color: #1e3a8a;">
                                    <i class="fas fa-chart-line me-2" style="color: #3b82f6;"></i>Final Grade
                                </h5>
                                
                                <div class="card bg-gradient mb-3" style="background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);">
                                    <div class="card-body text-center p-4">
                                        <div class="mb-2">
                                            <small class="text-white opacity-75" style="color: #ffffff !important;">Your Final Grade</small>
                                        </div>
                                        <div class="display-3 fw-bold mb-2 text-white" id="finalGrade" style="color: #ffffff !important;">0.00</div>
                                        <div class="h5 mb-0 text-white" id="gradeOutOf" style="color: #ffffff !important;">/ 20</div>
                                    </div>
                                </div>

                                <!-- Breakdown -->
                                <div class="row g-3 mb-3">
                                    <div class="col-md-4">
                                        <div class="card border-0 shadow-sm h-100">
                                            <div class="card-body text-center">
                                                <small class="text-muted d-block mb-1">Midterm Contribution</small>
                                                <div class="h4 fw-bold mb-0" style="color: #3b82f6;" id="midtermContribution">0.00</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card border-0 shadow-sm h-100">
                                            <div class="card-body text-center">
                                                <small class="text-muted d-block mb-1">Final Contribution</small>
                                                <div class="h4 fw-bold mb-0" style="color: #3b82f6;" id="finalContribution">0.00</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card border-0 shadow-sm h-100">
                                            <div class="card-body text-center">
                                                <small class="text-muted d-block mb-1">TP Contribution</small>
                                                <div class="h4 fw-bold mb-0" style="color: #3b82f6;" id="tpContribution">0.00</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Grade Interpretation -->
                                <div class="alert" id="gradeInterpretation" role="alert">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <span id="gradeMessage"></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let gradeScale = 20; // Default to /20

    // Toggle between /20 and /100 grade scales
    function toggleGradeScale() {
        const toggle = document.getElementById('gradeScaleToggle');
        gradeScale = toggle.checked ? 100 : 20;
        
        const maxValue = gradeScale;
        const maxText = '/ ' + gradeScale;
        
        // Update max values and labels
        document.getElementById('midtermScore').max = maxValue;
        document.getElementById('finalScore').max = maxValue;
        document.getElementById('tpScore').max = maxValue;
        
        document.getElementById('midtermMax').textContent = maxText;
        document.getElementById('finalMax').textContent = maxText;
        document.getElementById('tpMax').textContent = maxText;
        
        // Update placeholders
        document.getElementById('midtermScore').placeholder = 'Enter score (0-' + maxValue + ')';
        document.getElementById('finalScore').placeholder = 'Enter score (0-' + maxValue + ')';
        document.getElementById('tpScore').placeholder = 'Enter score (0-' + maxValue + ')';
        
        // Clear any existing results
        document.getElementById('resultSection').classList.add('d-none');
    }

    // Update total percentage when percentages change
    document.getElementById('midtermPercent').addEventListener('input', updateTotalPercent);
    document.getElementById('finalPercent').addEventListener('input', updateTotalPercent);
    document.getElementById('tpPercent').addEventListener('input', updateTotalPercent);

    function updateTotalPercent() {
        const midterm = parseFloat(document.getElementById('midtermPercent').value) || 0;
        const final = parseFloat(document.getElementById('finalPercent').value) || 0;
        const tp = parseFloat(document.getElementById('tpPercent').value) || 0;
        
        const total = midterm + final + tp;
        const totalElement = document.getElementById('totalPercent');
        const progressElement = document.getElementById('percentProgress');
        const warningElement = document.getElementById('percentWarning');
        
        totalElement.textContent = total.toFixed(1) + '%';
        progressElement.style.width = Math.min(total, 100) + '%';
        
        if (total !== 100) {
            totalElement.style.color = '#dc3545';
            progressElement.style.background = 'linear-gradient(135deg, #dc3545 0%, #c82333 100%)';
            warningElement.classList.remove('d-none');
        } else {
            totalElement.style.color = '#1e3a8a';
            progressElement.style.background = 'linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%)';
            warningElement.classList.add('d-none');
        }
    }

    function calculateGrade() {
        // Get values
        const midtermScore = parseFloat(document.getElementById('midtermScore').value) || 0;
        const finalScore = parseFloat(document.getElementById('finalScore').value) || 0;
        const tpScore = parseFloat(document.getElementById('tpScore').value) || 0;
        
        const midtermPercent = parseFloat(document.getElementById('midtermPercent').value) || 0;
        const finalPercent = parseFloat(document.getElementById('finalPercent').value) || 0;
        const tpPercent = parseFloat(document.getElementById('tpPercent').value) || 0;
        
        // Validate percentages total 100
        const totalPercent = midtermPercent + finalPercent + tpPercent;
        if (Math.abs(totalPercent - 100) > 0.1) {
            alert('Percentages must total exactly 100%. Current total: ' + totalPercent.toFixed(1) + '%');
            return;
        }
        
        // Validate scores are within range
        if (midtermScore < 0 || midtermScore > gradeScale || 
            finalScore < 0 || finalScore > gradeScale || 
            tpScore < 0 || tpScore > gradeScale) {
            alert('All scores must be between 0 and ' + gradeScale);
            return;
        }
        
        // Calculate contributions based on grade scale
        const midtermContribution = (midtermScore / gradeScale) * midtermPercent;
        const finalContribution = (finalScore / gradeScale) * finalPercent;
        const tpContribution = (tpScore / gradeScale) * tpPercent;
        
        // Calculate final grade
        const finalGrade = midtermContribution + finalContribution + tpContribution;
        const finalGradeOutOfScale = (finalGrade / 100) * gradeScale;
        
        // Display results
        document.getElementById('finalGrade').textContent = finalGradeOutOfScale.toFixed(2);
        document.getElementById('gradeOutOf').textContent = '/ ' + gradeScale;
        document.getElementById('midtermContribution').textContent = midtermContribution.toFixed(2);
        document.getElementById('finalContribution').textContent = finalContribution.toFixed(2);
        document.getElementById('tpContribution').textContent = tpContribution.toFixed(2);
        
        // Grade interpretation (based on /20 scale equivalent for consistency)
        const finalGradeOutOf20 = (finalGrade / 100) * 20;
        const interpretationElement = document.getElementById('gradeInterpretation');
        const messageElement = document.getElementById('gradeMessage');
        
        let message = '';
        let alertClass = '';
        
        if (finalGradeOutOf20 >= 16) {
            message = 'Excellent! You have achieved a very high grade.';
            alertClass = 'alert-success';
        } else if (finalGradeOutOf20 >= 14) {
            message = 'Very Good! You have a strong performance.';
            alertClass = 'alert-success';
        } else if (finalGradeOutOf20 >= 12) {
            message = 'Good! You have passed with a satisfactory grade.';
            alertClass = 'alert-info';
        } else if (finalGradeOutOf20 >= 10) {
            message = 'Passing grade. You have met the minimum requirements.';
            alertClass = 'alert-warning';
        } else {
            message = 'Below passing grade. You may need to retake the course.';
            alertClass = 'alert-danger';
        }
        
        interpretationElement.className = 'alert ' + alertClass;
        messageElement.textContent = message;
        
        // Show result section
        document.getElementById('resultSection').classList.remove('d-none');
        
        // Scroll to result
        document.getElementById('resultSection').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    // Allow Enter key to calculate
    document.getElementById('gradeCalculatorForm').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            calculateGrade();
        }
    });
</script>
@endsection
