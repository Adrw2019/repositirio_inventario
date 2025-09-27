
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Verificación en dos pasos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { background: linear-gradient(120deg, #e0e7ff 0%, #f4f6f8 100%); font-family: 'Montserrat', Arial, sans-serif; margin: 0; padding: 0; }
        .container { max-width: 400px; margin: 70px auto; background: #fff; border-radius: 16px; box-shadow: 0 8px 32px rgba(0,0,0,0.13); padding: 38px 32px 28px 32px; text-align: center; }
        .container h1 { color: #222; margin-bottom: 18px; }
        .container p { color: #555; margin-bottom: 18px; }
        .form-group { margin-bottom: 18px; text-align: left; }
        .form-group label { display: block; margin-bottom: 6px; color: #333; font-weight: 500; }
        .form-group input[type="text"] { width: 100%; padding: 10px 12px; border: 1px solid #bbb; border-radius: 6px; font-size: 1rem; }
        button { width: 100%; padding: 12px; background: linear-gradient(90deg, #6366f1 0%, #4f46e5 100%); color: #fff; border: none; border-radius: 8px; font-size: 1.08rem; cursor: pointer; font-weight: 600; box-shadow: 0 2px 8px rgba(79,70,229,0.08); transition: background 0.2s, transform 0.2s; margin-bottom: 10px; }
        button:hover { background: linear-gradient(90deg, #4f46e5 0%, #6366f1 100%); transform: translateY(-2px) scale(1.03); }
    </style>
</head>
<body>
    <div class="container">
        <h1><i class="fa-solid fa-shield-halved"></i> Verificación en dos pasos</h1>
        <?php if (isset($_GET['error'])): ?>
            <p style="color:red;">Código incorrecto, intenta de nuevo.</p>
        <?php endif; ?>
        <p>Ingresa el código que recibiste en tu correo electrónico.</p>
        <form action="../controllers/verificar_2fa.php" method="POST">
            <div class="form-group">
                <label for="codigo"><i class="fa-solid fa-key"></i> Código:</label>
                <input type="text" name="codigo" id="codigo" required maxlength="6" pattern="\d{6}">
            </div>
            <button type="submit">Verificar</button>
        </form>
    </div>
</body>
</html>