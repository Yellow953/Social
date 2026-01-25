@extends('layouts.dashboard')

@section('title', 'Calculator - Social Plus')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Calculator</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <!-- Page Header -->
            <div class="text-center mb-4">
                <h2 class="fw-bold mb-1" style="color: #1e3a8a;"><i class="fas fa-calculator me-2" style="color: #3b82f6;"></i>Calculator</h2>
                <p class="text-muted mb-0">Built-in calculator for your convenience</p>
            </div>

            <!-- Calculator -->
            <div class="card border-0 shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #3b82f6 !important;">
                <div class="card-body p-4">
                    <!-- Display -->
                    <div class="bg-light rounded p-4 mb-3 text-end">
                        <div class="text-muted small mb-2" id="expression">0</div>
                        <div class="h2 fw-bold mb-0" id="display">0</div>
                    </div>

                    <!-- Buttons -->
                    <div class="row g-2">
                        <!-- Row 1 -->
                        <div class="col-3">
                            <button class="btn btn-light w-100 py-3 fw-bold" onclick="clearAll()">C</button>
                        </div>
                        <div class="col-3">
                            <button class="btn btn-light w-100 py-3 fw-bold" onclick="clearEntry()">CE</button>
                        </div>
                        <div class="col-3">
                            <button class="btn btn-light w-100 py-3 fw-bold" onclick="appendOperator('%')">%</button>
                        </div>
                        <div class="col-3">
                            <button class="btn btn-warning w-100 py-3 fw-bold text-white" onclick="appendOperator('/')">÷</button>
                        </div>

                        <!-- Row 2 -->
                        <div class="col-3">
                            <button class="btn btn-secondary w-100 py-3 fw-bold text-white" onclick="appendNumber('7')">7</button>
                        </div>
                        <div class="col-3">
                            <button class="btn btn-secondary w-100 py-3 fw-bold text-white" onclick="appendNumber('8')">8</button>
                        </div>
                        <div class="col-3">
                            <button class="btn btn-secondary w-100 py-3 fw-bold text-white" onclick="appendNumber('9')">9</button>
                        </div>
                        <div class="col-3">
                            <button class="btn btn-warning w-100 py-3 fw-bold text-white" onclick="appendOperator('*')">×</button>
                        </div>

                        <!-- Row 3 -->
                        <div class="col-3">
                            <button class="btn btn-secondary w-100 py-3 fw-bold text-white" onclick="appendNumber('4')">4</button>
                        </div>
                        <div class="col-3">
                            <button class="btn btn-secondary w-100 py-3 fw-bold text-white" onclick="appendNumber('5')">5</button>
                        </div>
                        <div class="col-3">
                            <button class="btn btn-secondary w-100 py-3 fw-bold text-white" onclick="appendNumber('6')">6</button>
                        </div>
                        <div class="col-3">
                            <button class="btn btn-warning w-100 py-3 fw-bold text-white" onclick="appendOperator('-')">−</button>
                        </div>

                        <!-- Row 4 -->
                        <div class="col-3">
                            <button class="btn btn-secondary w-100 py-3 fw-bold text-white" onclick="appendNumber('1')">1</button>
                        </div>
                        <div class="col-3">
                            <button class="btn btn-secondary w-100 py-3 fw-bold text-white" onclick="appendNumber('2')">2</button>
                        </div>
                        <div class="col-3">
                            <button class="btn btn-secondary w-100 py-3 fw-bold text-white" onclick="appendNumber('3')">3</button>
                        </div>
                        <div class="col-3">
                            <button class="btn btn-warning w-100 py-3 fw-bold text-white" onclick="appendOperator('+')">+</button>
                        </div>

                        <!-- Row 5 -->
                        <div class="col-6">
                            <button class="btn btn-secondary w-100 py-3 fw-bold text-white" onclick="appendNumber('0')">0</button>
                        </div>
                        <div class="col-3">
                            <button class="btn btn-secondary w-100 py-3 fw-bold text-white" onclick="appendNumber('.')">.</button>
                        </div>
                        <div class="col-3">
                            <button class="btn btn-success w-100 py-3 fw-bold text-white" onclick="calculate()">=</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let display = '0';
    let expression = '';
    let shouldResetDisplay = false;

    function updateDisplay() {
        document.getElementById('display').textContent = display;
        document.getElementById('expression').textContent = expression || '0';
    }

    function appendNumber(num) {
        if (shouldResetDisplay) {
            display = '0';
            shouldResetDisplay = false;
        }
        if (display === '0' && num !== '.') {
            display = num;
        } else {
            display += num;
        }
        updateDisplay();
    }

    function appendOperator(op) {
        if (expression && !shouldResetDisplay) {
            calculate();
        }
        expression = display + ' ' + op;
        shouldResetDisplay = true;
        updateDisplay();
    }

    function calculate() {
        if (!expression) return;

        const parts = expression.split(' ');
        if (parts.length !== 2) return;

        const num1 = parseFloat(parts[0]);
        const num2 = parseFloat(display);
        const operator = parts[1];

        let result;
        switch(operator) {
            case '+':
                result = num1 + num2;
                break;
            case '−':
                result = num1 - num2;
                break;
            case '×':
                result = num1 * num2;
                break;
            case '÷':
                result = num1 / num2;
                break;
            case '%':
                result = num1 % num2;
                break;
            default:
                return;
        }

        display = result.toString();
        expression = '';
        shouldResetDisplay = true;
        updateDisplay();
    }

    function clearAll() {
        display = '0';
        expression = '';
        updateDisplay();
    }

    function clearEntry() {
        display = '0';
        updateDisplay();
    }

    // Keyboard support
    document.addEventListener('keydown', function(e) {
        if (e.key >= '0' && e.key <= '9' || e.key === '.') {
            appendNumber(e.key);
        } else if (e.key === '+' || e.key === '-') {
            appendOperator(e.key === '+' ? '+' : '−');
        } else if (e.key === '*') {
            appendOperator('×');
        } else if (e.key === '/') {
            e.preventDefault();
            appendOperator('÷');
        } else if (e.key === 'Enter' || e.key === '=') {
            calculate();
        } else if (e.key === 'Escape') {
            clearAll();
        }
    });
</script>
@endsection
