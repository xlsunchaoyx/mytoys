<!doctype html>
<html lang="zh-cn">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Tools</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
        <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- 可选的 Bootstrap 主题文件（一般不用引入） -->
        <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

        <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
        <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }



        </style>
    </head>
    <body>

        <div class="container">
            <div class="row">
                <a class="btn btn-default btn-lg active" href="/">拆分产品和数量</a>
                <a class="btn btn-primary btn-lg active" href="/step2">合并</a>
            </div>

            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">

                    <form action="/step2" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <p class="bg-danger">{{ $error }}</p>
                        <div class="form-group">
                            <label for="exampleInputFile" style="color:red;">第二步</label>
                            <input type="file" id="exampleInputFile" name='file'>
                            <p class="help-block"></p>
                        </div>
                        <button type="submit" class="btn btn-default">提交</button>
                    </form>

                </div>
                  
                <div class="col-md-4"></div>
            </div>
        </div>

        <div class="flex-center position-ref full-height">

            

        </div>
    </body>
</html>
