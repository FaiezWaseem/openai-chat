<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/dark.css">
</head>
<body>
    <div>
        <form action="text-generate.php" method="post">
            <div>
                <input type="text" name="prompt" placeholder="shoe, burger, etc" />
            </div>
            <div>
                <input type="text" name="image" placeholder="image link" />
            </div>
            <br>
            <div>
                <input type="submit" value="Generate" />
            </div>
        </form>
    </div>
    <hr>
</body>
</html>