<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        body{
            margin: 0;
        }
        
        .amap-marker-label{
            font-size: 14px;
            padding: 2px;
            background-color: white;
            border: none;
            cursor: pointer;
            border-radius: 2px;
        }
        .amap-marker-label span{
            border: none;
            margin: 1px;
        }
        .amap-marker-label img{
            height: 16px;
            vertical-align: -3px;
        }
        .amap-icon{
            display: none;
        }
        .new-amap-icon{
            position: absolute;
            left: -30px;
            top: 0;
        }
        .amap-marker-label:before{
            content: '';
            position: absolute;
            width: 8px;
            height: 8px;
            background:#F88C57;
            -webkit-border-radius:4px;
            -moz-border-radius:4px;
            border-radius:4px;
            left: -10px;
            top: 6px;
        }
        
    </style>
</head>
<body>
    

<script type="text/javascript" src='//webapi.amap.com/maps?v=1.4.3&key=6e4d02aa84a4cc6669b16788c01ac14a'></script>
<!-- UI组件库 1.0 -->
<script src="//webapi.amap.com/ui/1.0/main.js?v=1.0.11"></script>
<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
   
</script>
</body>
</html>