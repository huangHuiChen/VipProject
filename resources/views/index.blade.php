<!DOCTYPE html>
<html lang="zh-tw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>會員贈獎查詢平台</title>
    <!--<link href="{{ asset('css/app.css') }}" rel="stylesheet">-->

    @vite('resources/js/app.js')
</head>
<body>
    
    <div id="app">
        <home-page :nav-items="{{ json_encode($navItems) }}">
        <pre>
        說明: 今後若有開發或更新時，會公告在此，此期間會無法使用此平台
        公告: 
        </pre>
        </home-page>
    </div>
    
    <!--<script src="{{ asset('js/app.js') }}"></script>-->
</body>
</html>