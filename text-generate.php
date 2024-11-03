<?php


$env = parse_ini_file('.env');

$open_ai_key = $env['OPENAI_API_KEY'];

$prompt = $_POST['prompt'];
$image = $_POST['image'];

// $imageQ2 = "https://i.ibb.co/dBCxmnM/Whats-App-Image-2024-11-02-at-16-49-39-ec25c520.jpg";
// $image = "https://gya.tec.edu.pk/public/tmp/Q8.jpg";


function promptWithImage($prompt, $image)
{
    global $open_ai_key;

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.openai.com/v1/chat/completions",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "{\n    \"model\": \"gpt-4o\",\n    \"messages\": [\n      {\n        \"role\": \"user\",\n        \"content\": [\n          {\n            \"type\": \"text\",\n            \"text\": \"$prompt\"\n          },\n          {\n            \"type\": \"image_url\",\n            \"image_url\": {\n              \"url\": \"$image\"\n            }\n          }\n        ]\n      }\n    ],\n    \"max_tokens\": 600\n  }\n",
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer $open_ai_key",
            "Content-Type: application/json"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    }

    file_put_contents('output.txt', $response);
    $rr = json_decode($response, true);
    $answer = $rr['choices'][0]['message']['content'];
    return $answer;
}

function promptWithText($prompt)
{

    global $open_ai_key;

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.openai.com/v1/chat/completions",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "{\n    \"model\": \"gpt-4o\",\n    \"messages\": [\n      {\n        \"role\": \"system\",\n        \"content\": \"You are a helpful assistant.\"\n      },\n      {\n        \"role\": \"user\",\n        \"content\": \"$prompt\"\n      }\n    ]\n  }",
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer $open_ai_key",
            "Content-Type: application/json"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        file_put_contents('output.txt', $response);
        $rr = json_decode($response, true);
        $answer = $rr['choices'][0]['message']['content'];
        return $answer;
    }
}


$answer = '';

if ($prompt) {
    if (isset($image) && !empty($image)) {
        $answer = promptWithImage($prompt, $image);
    } else {
        $answer = promptWithText($prompt);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Output</title>
    <style>
        .output-text {
            white-space: break-spaces;
        }
    </style>
    <script async src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/3.2.0/es5/tex-mml-chtml.js" />
    <script>
        window.MathJax = {
            tex: {
                inlineMath: [['$', '$'], ['\\\\(', '\\\\)']],
            },
            svg: {
                fontCache: 'global',
            },
        };
    </script>

</head>

<body>
    <h1>Out Put : <?= $prompt ?></h1>
    <img src="<?= $image ?>" alt="promt-image" width="300px">
    <div class="output-text">
        <hr>
        <?= $answer ?>
    </div>

    <script>
        if (window.MathJax) {
            window.MathJax.startup.promise
                .then(() => {
                    window.MathJax.typesetPromise();
                })
                .catch((err) => console.error("MathJax startup error:", err));
        }

    </script>
</body>

</html>