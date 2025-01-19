<?php
session_start();

// Initialize score tracking
if (!isset($_SESSION['test_attempts'])) {
    $_SESSION['test_attempts'] = 0;
}

$questions = [
    1 => [
        'question' => 'Aká je cena produktu Algorytm 1?',
        'options' => [
            'a' => '$3',
            'b' => '$5',
            'c' => '$7',
            'd' => '$10'
        ],
        'correct' => 'b'
    ],
    2 => [
        'question' => 'Aká je maximálna cena medzi vrtuľníkmi?',
        'options' => [
            'a' => '$70,000',
            'b' => '$150,000',
            'c' => '$1,000,000',
            'd' => '$15,700,000'
        ],
        'correct' => 'd'
    ],
    3 => [
        'question' => 'Koľko produktov Algorytm je k dispozícii v obchode?',
        'options' => [
            'a' => '3',
            'b' => '4',
            'c' => '5',
            'd' => '6'
        ],
        'correct' => 'c'
    ]
];

$message = '';
$score = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['answers'])) {
        foreach ($_POST['answers'] as $question_id => $answer) {
            if ($answer === $questions[$question_id]['correct']) {
                $score++;
            }
        }
        $_SESSION['test_attempts']++;
        
        if ($score >= 2) {
            $message = '<div class="success">Gratulujeme! Úspešne ste absolvovali test! Správne odpovede sú: ' . $score . ' з 3</div>';
        } else {
            $message = '<div class="error">Skúste to znova. Správne odpovede: ' . $score . ' з 3</div>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тест - Obhod TUKE</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .header {
            background: linear-gradient(135deg, #000000 0%, #000000 100%);
            color: white;
            padding: 1rem;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        
        .question {
            margin-bottom: 30px;
            padding: 20px;
            border: 1px solid #eee;
            border-radius: 4px;
        }
        
        .options label {
            display: block;
            margin: 10px 0;
            padding: 10px;
            background: #f9f9f9;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .options label:hover {
            background: #f0f0f0;
        }
        
        input[type="radio"] {
            margin-right: 10px;
        }
        
        .submit-btn {
            background: #000000;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            transition: background 0.3s;
        }
        
        .submit-btn:hover {
            background: #333;
        }
        
        .success {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        
        .navigation {
            margin-top: 20px;
            text-align: center;
        }
        
        .nav-btn {
            display: inline-block;
            padding: 10px 20px;
            background: #000;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin: 0 10px;
        }
        
        .attempts {
            text-align: center;
            margin-bottom: 20px;
            color: #666;
        }
        #logo-container {
    position: absolute;
    top: -65px;
    left: 20px;
    z-index: 10;
}

.logo {
    width: 200px;
    height: 200px;
    transition: transform 0.3s ease;
}

.logo:hover {
    transform: scale(1.05);
}
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Test znalostí o obchode</h1>
        </div>
        <div id="logo-container">
        <a href="index.html">
            <img src="logo.svg" alt="Logo" class="logo">
        </a>
    </div>
        
        <?php if ($message): ?>
            <?php echo $message; ?>
        <?php endif; ?>
        
        <div class="attempts">
        Počet pokusov: <?php echo $_SESSION['test_attempts']; ?>
        </div>
        
        <form method="POST" action="test.php">
            <?php foreach ($questions as $id => $question): ?>
                <div class="question">
                    <h3>Otázka. <?php echo $id; ?>:</h3>
                    <p><?php echo $question['question']; ?></p>
                    <div class="options">
                        <?php foreach ($question['options'] as $key => $option): ?>
                            <label>
                                <input type="radio" name="answers[<?php echo $id; ?>]" value="<?php echo $key; ?>" required>
                                <?php echo $option; ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            
            <button type="submit" class="submit-btn">Potvrdenie odpovedí</button>
        </form>
        
        <div class="navigation">
            <a href="index.html" class="nav-btn">Späť do obchodu</a>
        </div>
    </div>
</body>
</html>