<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance | Jajan Bang</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #fff7ed 0%, #fed7aa 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            text-align: center;
            padding: 2rem;
            max-width: 400px;
        }
        .icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 2rem;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        h1 {
            font-size: 2rem;
            color: #ea580c;
            margin-bottom: 1rem;
        }
        p {
            color: #78716c;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        .loader {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
        }
        .loader span {
            width: 12px;
            height: 12px;
            background: #ea580c;
            border-radius: 50%;
            animation: bounce 1.4s infinite ease-in-out both;
        }
        .loader span:nth-child(1) { animation-delay: -0.32s; }
        .loader span:nth-child(2) { animation-delay: -0.16s; }
        @keyframes bounce {
            0%, 80%, 100% { transform: scale(0); }
            40% { transform: scale(1); }
        }
    </style>
</head>
<body>
    <div class="container">
        <svg class="icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" stroke="#ea580c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        
        <h1>Sedang Maintenance</h1>
        <p>
            Kami sedang melakukan pemeliharaan sistem untuk meningkatkan pengalaman kamu. 
            Silakan kembali beberapa saat lagi.
        </p>
        
        <div class="loader">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</body>
</html>
