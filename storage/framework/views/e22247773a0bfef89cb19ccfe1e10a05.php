
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CartNova – Sign In</title>

    <style>
         *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        :root{--orange:#FF9900;--hdr:#131921;--nav:#232f3e;--text:#0F1111;--muted:#565959;--link:#007185;--border:#ddd;--bg:#EAEDED;--white:#fff;--error:#CC0C39;--green:#007600;}
        body{font-family:Arial,sans-serif;background:var(--bg);color:var(--text);font-size:14px;min-height:100vh;display:flex;flex-direction:column}
        a{text-decoration:none;color:var(--link)}
        a:hover{text-decoration:underline;color:#C45500}

        /* HEADER */
        .header{
            background:#131921;
            padding:14px 20px;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .logo{
            font-size:34px;
            font-weight:900;
            color:#fff;
            letter-spacing:-1px;
            text-decoration:none;
            position:relative;
            animation:fadeDown .6s ease;
        }

        .logo span{
            color:#FF9900;
        }

        @keyframes fadeDown{
            from{opacity:0;transform:translateY(-10px)}
            to{opacity:1;transform:translateY(0)}
        }

        /* CARD */
        .main{
            flex:1;
            display:flex;
            justify-content:center;
            align-items:center;
            padding:20px;
        }

        .card{
            width:360px;
            background:#fff;
            border:1px solid #ddd;
            border-radius:8px;
            padding:20px;
            box-shadow:0 10px 25px rgba(0,0,0,0.08);
            animation:fadeUp .6s ease;
        }

        @keyframes fadeUp{
            from{opacity:0;transform:translateY(20px)}
            to{opacity:1;transform:translateY(0)}
        }

        .card__title{
            font-size:26px;
            font-weight:700;
            margin-bottom:15px;
            color:#111;
        }

        /* INPUT */
        .field{margin-bottom:14px}

        .field__label{
            font-size:13px;
            font-weight:700;
            display:block;
            margin-bottom:6px;
        }

        .field__input{
            width:100%;
            padding:10px;
            border:1px solid #ccc;
            border-radius:4px;
            outline:none;
            transition:.2s;
        }

        .field__input:focus{
            border-color:#FF9900;
            box-shadow:0 0 0 3px rgba(255,153,0,0.2);
        }

        .btn{
            width:100%;
            padding:10px;
            background:linear-gradient(to bottom,#f7dfa5,#f0c14b);
            border:1px solid #a88734;
            border-radius:20px;
            font-weight:700;
            cursor:pointer;
            transition:.2s;
        }

        .btn:hover{
            transform:scale(1.02);
        }

        .link{
            color:#007185;
            text-decoration:none;
        }

        .link:hover{
            text-decoration:underline;
            color:#C45500;
        }

        .divider{
            margin:15px 0;
            border:none;
            border-top:1px solid #ddd;
        }

         footer{background:var(--hdr);color:#ccc;text-align:center;padding:16px;margin-top:auto}
        .foot-links{display:flex;justify-content:center;flex-wrap:wrap;gap:6px 20px;margin-bottom:8px}
        .foot-links a{color:#ccc;font-size:.78rem}
        .foot-copy{font-size:.75rem;color:#888}
        

        /* FLOAT ANIMATION */
        .card:hover{
            transform:translateY(-2px);
            transition:.3s;
        }

        /* ERROR */
        .alert{
            font-size:13px;
            padding:8px 10px;
            border-radius:4px;
            margin-bottom:10px;
        }

        .alert--error{
            background:#fff0f0;
            border:1px solid #cc0c39;
            color:#cc0c39;
        }

        .alert--success{
            background:#f0fff4;
            border:1px solid #007600;
            color:#007600;
        }

    </style>
</head>

<body>

<header class="header">
    <a href="/" class="logo">Cart<span>Nova</span></a>
</header>

<main class="main">
    <div class="card">

        <h1 class="card__title">Sign in</h1>

        <?php if(session('status')): ?>
            <div class="alert alert--success"><?php echo e(session('status')); ?></div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="alert alert--error">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div><?php echo e($error); ?></div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('login.submit')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <div class="field">
                <label class="field__label">Email</label>
                <input type="text" name="email" class="field__input" value="<?php echo e(old('email')); ?>">
            </div>

            <div class="field">
                <label class="field__label">Password</label>
                <input type="password" name="password" class="field__input">
            </div>

            <button class="btn">Continue</button>

        </form>

        <hr class="divider">

        <p style="font-size:13px">
            New to CartNova?
            <a href="<?php echo e(route('register')); ?>" class="link">Create account</a>
        </p>

        <p style="margin-top:10px;font-size:12px">
            <a href="<?php echo e(route('password.request')); ?>" class="link">Forgot password?</a>
        </p>

    </div>
</main>


<?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

</body>
</html><?php /**PATH C:\xampp\htdocs\laravel\userside_project\resources\views/auth/login.blade.php ENDPATH**/ ?>