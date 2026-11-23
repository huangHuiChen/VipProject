<html lang="zh-Tw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>會員贈獎查詢平台</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/js/app.js')
</head>
<body>
    <div id="app">
            <testB
            :nav-items="{{ json_encode($navItems) }}"
            :options="{{ json_encode($options) }}"
            >
            </testB>
    </div>
    
</body>
</html>
