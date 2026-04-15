{{-- resources/views/payment/index.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Payment</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=DM+Mono:wght@500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #f0f2f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
        }

        .card {
            background: #fff;
            border-radius: 20px;
            width: 100%;
            max-width: 400px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0,0,0,0.10);
        }

        .top {
            background: #1a3c2e;
            padding: 28px 28px 24px;
            color: #fff;
        }
        .brand {
            font-size: 11px;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            opacity: 0.55;
            margin-bottom: 16px;
        }
        .order-ref {
            font-family: 'DM Mono', monospace;
            font-size: 13px;
            opacity: 0.65;
        }

        .body {
            padding: 36px 28px 28px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 20px;
        }

        .ring-wrap {
            position: relative;
            width: 88px;
            height: 88px;
        }
        .ring-wrap svg { position: absolute; top: 0; left: 0; }

        @keyframes spin-ring { to { stroke-dashoffset: -251; } }
        @keyframes pop-in { from{transform:scale(0);opacity:0} 80%{transform:scale(1.15)} to{transform:scale(1);opacity:1} }

        .ring-track { fill: none; stroke: #e5e7eb; stroke-width: 5; }
        .ring-fill  {
            fill: none; stroke-width: 5; stroke-linecap: round;
            transform-origin: center; transform: rotate(-90deg);
            stroke-dasharray: 251; stroke-dashoffset: 251;
            transition: stroke 0.3s;
        }
        .ring-fill.spin { animation: spin-ring 1.4s linear infinite; }
        .ring-fill.done { animation: none; stroke-dashoffset: 0; transition: stroke-dashoffset 0.6s ease, stroke 0.3s; }

        .ring-icon { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; }
        .ring-icon svg { display: none; }
        .ring-icon svg.show { display: block; animation: pop-in 0.4s ease forwards; }

        .status-label {
            font-size: 17px;
            font-weight: 600;
            color: #111;
        }
        .status-sub {
            font-size: 13px;
            color: #6b7280;
            line-height: 1.6;
            max-width: 280px;
            margin-top: 4px;
        }

        .btn-retry {
            display: none;
            width: 100%;
            height: 48px;
            background: #1a3c2e;
            color: #fff;
            border: none;
            border-radius: 12px;
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background .15s;
        }
        .btn-retry:hover { background: #12291f; }
        .btn-retry.show { display: block; }

        .footer {
            font-size: 11px;
            color: #9ca3af;
            padding-bottom: 24px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="card">
    <div class="top">
        <div class="brand">Premium Farming Feeds</div>
        <div class="order-ref">Order #{{ $orderId }}</div>
    </div>

    <div class="body">
        <div class="ring-wrap">
            <svg width="88" height="88" viewBox="0 0 88 88">
                <circle class="ring-track" cx="44" cy="44" r="40"/>
                <circle class="ring-fill spin" id="ring" cx="44" cy="44" r="40" stroke="#1a3c2e"/>
            </svg>
            <div class="ring-icon">
                <svg id="icon-sending" class="show" width="26" height="26" viewBox="0 0 24 24" fill="none"
                     stroke="#1a3c2e" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="5" y="2" width="14" height="20" rx="2"/>
                    <line x1="12" y1="18" x2="12" y2="18.01"/>
                </svg>
                <svg id="icon-success" width="32" height="32" viewBox="0 0 24 24" fill="none"
                     stroke="#16a34a" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                <svg id="icon-fail" width="26" height="26" viewBox="0 0 24 24" fill="none"
                     stroke="#dc2626" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </div>
        </div>

        <div>
            <div class="status-label" id="status-label">Processing payment…</div>
            <div class="status-sub" id="status-sub">Sending M-Pesa prompt to your number.</div>
        </div>

        <button class="btn-retry" id="btn-retry" onclick="initiatePayment()">Try Again</button>
    </div>

    <div class="footer">Secured by M-Pesa &bull; Safaricom</div>
</div>

<script>
    const ORDER_ID = '{{ $orderId }}';
    const TOKEN    = '{{ $token }}';
    const CSRF     = '{{ csrf_token() }}';

    let pollTimer    = null;
    let pollAttempts = 0;
    const MAX_POLLS  = 24; // 24 × 5s = 2 minutes

    function setIcon(name) {
        ['sending', 'success', 'fail'].forEach(n =>
            document.getElementById('icon-' + n).classList.remove('show')
        );
        document.getElementById('icon-' + name).classList.add('show');
    }

    function setState(state, label, sub) {
        document.getElementById('status-label').textContent = label;
        document.getElementById('status-sub').textContent   = sub;

        const ring  = document.getElementById('ring');
        const retry = document.getElementById('btn-retry');

        if (state === 'loading') {
            ring.style.stroke = '#1a3c2e';
            ring.classList.add('spin');
            ring.classList.remove('done');
            setIcon('sending');
            retry.classList.remove('show');

        } else if (state === 'waiting') {
            ring.style.stroke = '#d97706';
            ring.classList.add('spin');
            ring.classList.remove('done');
            setIcon('sending');
            retry.classList.remove('show');

        } else if (state === 'success') {
            ring.classList.remove('spin');
            ring.classList.add('done');
            ring.style.stroke = '#16a34a';
            setIcon('success');
            retry.classList.remove('show');

        } else if (state === 'failed') {
            ring.classList.remove('spin');
            ring.classList.remove('done');
            ring.style.stroke = '#dc2626';
            setIcon('fail');
            retry.classList.add('show');
        }
    }

    function initiatePayment() {
        clearInterval(pollTimer);
        pollAttempts = 0;
        setState('loading', 'Processing payment…', 'Sending M-Pesa prompt to your number.');

        // Only order_id and token — phone is already on the order in Django
        fetch('/api/ecommerce/pay/', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept':       'application/json',
            },
            body: JSON.stringify({
                order_id: ORDER_ID,
                token:    TOKEN,
            }),
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                setState(
                    'waiting',
                    'Check your phone',
                    'Enter your M-Pesa PIN on the prompt sent to your number.'
                );
                startPolling();
            } else {
                setState('failed', 'Could not send prompt', data.message || 'Please try again.');
            }
        })
        .catch(() => {
            setState('failed', 'Network error', 'Check your connection and try again.');
        });
    }

    function startPolling() {
        pollTimer = setInterval(() => {
            pollAttempts++;

            if (pollAttempts > MAX_POLLS) {
                clearInterval(pollTimer);
                setState('failed', 'Timed out', 'No confirmation received. If you entered your PIN, contact support.');
                return;
            }

            fetch(`/api/ecommerce/payment/status/${ORDER_ID}?token=${TOKEN}`, {
                headers: { 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                if (data.status === 'PAID' || data.status === 'completed') {
                    clearInterval(pollTimer);
                    setState('success', 'Payment confirmed!', 'Thank you. Your order is on its way.');
                } else if (data.status === 'failed') {
                    clearInterval(pollTimer);
                    setState('failed', 'Payment declined', data.message || 'The transaction was not completed.');
                }
                // any other status (pending) — keep polling silently
            })
            .catch(() => { /* silent — keep polling */ });

        }, 5000);
    }

    // Auto-trigger on page load
    window.addEventListener('DOMContentLoaded', initiatePayment);
</script>
</body>
</html>