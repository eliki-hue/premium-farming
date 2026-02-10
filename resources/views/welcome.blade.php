<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Premium Farming Feeds</title>
        
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            body { 
                font-family: system-ui, -apple-system, sans-serif; 
                background: #f8f9fa; 
                text-align: center; 
                padding: 2rem; 
            }
            .container { 
                max-width: 800px; 
                margin: 0 auto; 
                padding: 3rem 1rem; 
            }
            h1 { 
                color: #2a6e3f; 
                margin-bottom: 1.5rem; 
                font-size: 2.5rem; 
            }
            p { 
                color: #666; 
                margin-bottom: 2rem; 
                font-size: 1.1rem; 
            }
            .btn { 
                display: inline-block; 
                background: #2a6e3f; 
                color: white; 
                padding: 0.8rem 2rem; 
                text-decoration: none; 
                border-radius: 4px; 
                font-weight: 600; 
                margin: 0.5rem; 
            }
            .btn:hover { 
                background: #22543d; 
            }
            .logo { 
                max-width: 200px; 
                margin-bottom: 2rem; 
            }
            @media (max-width: 768px) {
                h1 { font-size: 2rem; }
                .container { padding: 2rem 1rem; }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <img src="{{ asset('images/logo.jpeg') }}" alt="Premium Farming Feeds" class="logo">
            <h1>Welcome to Premium Farming Feeds</h1>
            <p>Quality livestock nutrition solutions for Kenyan farmers</p>
            
            <div>
                <a href="{{ route('products') }}" class="btn">Browse Products</a>
                <a href="/about" class="btn" style="background: #6c757d;">About Us</a>
                <a href="/contact" class="btn" style="background: #198754;">Contact</a>
            </div>
        </div>
    </body>
</html>